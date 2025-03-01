#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import unicodedata
import os, sys, argparse, codecs, subprocess, shutil
import settings
import re

def open_file(filename, encoding='utf8'):
    """
    Open file and load content into string.
    
    Returns the content as decoded string.
    """

    # Try opening the file
    try:
        f = codecs.open(filename, 'rb', encoding)
        s = f.read()
    except IOError as err:
        print('Cannot open {}'.format(err))
    except:
        print('Unexpected error:', sys.exc_info()[0])
        print('Did you remember to add the -betacode argument '
              'if your input is in beta-code format?')
    else:
        f.close()

        return(s)

def content_of_files(question, beta_conversion=False):
    """Determine whether input is file or directory and load content
    into list.
    If enabled, convert beta code via tlgu

    Keyword Arguments: question -- string that is either a file or
    directory.

    """

    # Create the list
    content_list = []

    # If its a dir, I assume it is unicode (folders with beta-encoding
    # are not accepted). Intended to be a folder with output of the
    # tlgu script
    if os.path.isdir(question):
        for dirname, dirnames, filenames in os.walk(question):
            for filename in filenames:
                content_list.append(open_file(os.path.join(dirname, filename)))
        
    # If it is a file, it can either be unicode or beta-code. If
    # cmd-line argument for beta-conversion is true, the convert and
    # return a list, else the list is just the single file.
    elif os.path.isfile(question):
        if beta_conversion is True:
            print('Beta conversion enabled and starting now.')
            content_list = beta_code_convert(question)
        else:
            print('Reading content of single file')
            content_list = [open_file(question)]

    else:
        sys.exit('Specified file or directory does not exist. '
                 'Closing.')

    return(content_list)

def beta_code_convert(file):
    """Convert input var content from beta-code to unicode. Calls the
    tlgu program (see http://tlgu.carmen.gr/). 

    Keyword Arguments:
    content -- string in beta-code encoding
    """

    # Create temp folder for the processing and load content into file
    tempdir_name = 'temp/'
    if not os.path.exists(tempdir_name):
        os.makedirs(tempdir_name)

    # Check if tlgu is on system and convert.
    # Search for tlgu in current working dir 
    if subprocess.call(['type', 'tlgu']) is 0:
        print('Found tlgu in PATH... converting')
        subprocess.call(['tlgu', '-W', file, '%soutput' %tempdir_name])
        print('tlgu done with {0}'.format(file))

    elif subprocess.call(['type', './tlgu']) is 0:
        print('Found tlgu in current working dir... Processing')
        subprocess.call(['./tlgu', '-WC', file, '%soutput' %tempdir_name])
        print('tlgu done with {0}'.format(file))

    else:
        sys.exit('tlgu not installed or in current directory. I quit.\n'
                 'Download tlgu from http://tlgu.carmen.gr/, follow '
                 'the installation instructions and put it in your '
                 'PATH or in the currenct working directory of this '
                 'script.')

    # output into var
    output = content_of_files(tempdir_name)

    # remove temp dir
    shutil.rmtree(tempdir_name)
    
    # return output
    return(output)

def strip_accents(string):
    """Remove accents from string of greek characters.

    Keyword Arguments: string -- unicode encoded string

    """

    return ''.join(c for c in unicodedata.normalize('NFD', string)
                   if unicodedata.category(c) != 'Mn')    

def process_files(args):
    """ Run the files and apply the choosen changes. Return list with
    the processed content of the files. Either as one or several items
    dependant on the merge-option.

    Keyword Arguments:
    file_list -- list of files from file_list function
    args      -- command line arguments
    """

    print('Start processing the files')

    # Iterate over list of content from file(s), output to
    # processed_content
    processed_content = []
    for item in content_of_files(args.input, args.betacode):

        # Run the arguments
        if args.accents:
            item = strip_accents(item)

        if args.linebreaks:
            item = re.sub(r'-?\n', '', item)

        if args.whitespace:
            item = re.sub('[ \t]+', ' ', item)

        processed_content.append(item)

    print('File processing done.')
    
    # Prepare to return, either merged or in list.
    # If merged, prepend the [number] {work} text to each.
    if args.merge:
        output = ""
        for item in processed_content:
            output += '[{0}] {{work}} {1}'.format(
                processed_content.index(item), item
            )
        return(output)
    else:
        return(processed_content)

def create_output(content, args):
    """Determine output location, write the files and (if chosen) print
    output to shelle to.

    Keyword Arguments:
    args         -- the command line arguments specifying print and
    where to put the files.
    content -- the content to be printed to files.

    """

    # Set output dir: either cmd-line argument or current working dir.
    if args.output:
        output_directory = os.path.abspath(args.output)
    else:
        output_directory = os.getcwd()

    # If output dir does not exist, create it.
    if not os.path.isdir(output_directory):
        os.makedirs(output_directory)

    # If content is a list, there are several works by the author, and
    # the merge option is not chosen, so we iterate the list and
    # output a file for each item, else just output one file.
    # If the print option is set, print to shell too.
    if type(content) is list:
        for index, item in enumerate(content):
            output_file = open(os.path.join(output_directory,
                                            'output%s.txt' %index), 'w+')
            output_file.write(item)
            print('Output work {0} to {1}'.format(index, output_directory))
            if args.print:
                print('Work {}'.format(index))
                print(item)
    else:
        output_file = open(os.path.join(output_directory,
                                        'output.txt'), 'w+')
        output_file.write(content)
        print('Output work(s) merged to {}/output.txt'.format(output_directory))
        if args.print:
            print(content)

def main():
    """Main function. 

    Initiate argument parser and run appropriate
    functions.
    """

    # Parse command line arguments
    parser = argparse.ArgumentParser(
        description='Pre-process text files for corpus processing. '
        'The output is suited for the positions.py script.')
    parser.add_argument('input',
                        help='The folder or file to be parsed.')
    parser.add_argument('output', nargs='?',
                        help='The folder where the processed corpus '
                        'files will be stored. If none is given, the '
                        'file will be placed in the current working '
                        'directory.',
                        default=os.getcwd())
    parser.add_argument('--betacode', '-b',
                        help='Is the file in beta-code? In that case '
                        'it should be converted. Requires tlgu. '
                        'Default = False',
                        action='store_true')
    parser.add_argument('--print', '-p',
                        help='Output the result to shell? '
                        'Default = False.',
                        action='store_true')
    parser.add_argument('--accents', '-a',
                        help='Strip accents. Default = False.',
                        action='store_true')
    parser.add_argument('--whitespace', '-w',
                        help='Remove excessive whitespace. '
                        'Default = False.',
                        action='store_true')
    parser.add_argument('--linebreaks', '-l',
                        help='Remove all linebreaks. Default = False.',
                        action='store_true')
    parser.add_argument('--merge', '-m',
                        help='Merge the files into one corpus-file. '
                        'If this option is used, each work has '
                        '"[<number>] {work}" prepended for later '
                        'analysis. Default = False.', 
                        action='store_true')

    # Parse command line arguments
    args = parser.parse_args()

    # Process the file(s)
    create_output(process_files(args), args)

if __name__ == "__main__":
    main()
