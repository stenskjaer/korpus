<?php
/* Document: adjust_acccents
 * Output: erstatter alle gravis m. akut i dokument $author i $dir.
 */
header('Content-Type: text/html;charset=UTF-8');

// Input author
$author = 'theognis';

// Set dir
$dir = '/Users/Michael/Dropbox/Filologi/Workspace/Projects/kardinaldyderne/ordstudier/Corpora' .DIRECTORY_SEPARATOR. $author .DIRECTORY_SEPARATOR;

// Set new file name
$new_file = $dir . $author .'-corpus.txt';

// Count files in folder
$works = count(glob($dir . "/*"));

// In case counting starts from > 1, input highest number (dårlig løsning)
//$works = 6;


function renameFiles($directory) {
	$handler = opendir($directory) or die("Invalid Directory");
	while ($file = readdir($handler)) {
		if ($file != "." && $file != "..") {
			$newName = preg_replace('/(-00|-0)/','-',$file);
			rename($directory .DIRECTORY_SEPARATOR. $file, $directory .DIRECTORY_SEPARATOR. $newName);
		}
	}
    // clean up
    closedir($handler);
}

renameFiles($dir);

if(file_get_contents($dir .DIRECTORY_SEPARATOR. $author."-1.txt")) {
	$temp_dir = $dir . $author."-1.txt";
	$content = "[1] {Work} " . file_get_contents($temp_dir);
}

for($i=02; $i<$works+1; $i++){
	$file = $dir . $author. "-".$i.".txt";
	if(file_get_contents($file)) {
		$content .= "[$i] {Work}" . file_get_contents($file);
	}
}



$search =  explode(",","ά,ὰ,ᾶ,ἀ,ἄ,ἂ,ἆ,ἁ,ἅ,ἃ,ἇ,ᾱ,ᾰ,έ,ὲ,ἐ,ἔ,ἒ,ἑ,ἕ,ἓ,ή,ὴ,ῆ,ἠ,ἤ,ἢ,ἦ,ἡ,ἥ,ἣ,ἧ,ί,ὶ,ῖ,ἰ,ἴ,ἲ,ἶ,ἱ,ἵ,ἳ,ἷ,ϊ,ΐ,ῒ,ῗ,ό,ὸ,ὀ,ὄ,ὂ,ὁ,ὅ,ὃ,ύ,ὺ,ῦ,ὐ,ὔ,ὒ,ὖ,ὑ,ὕ,ὓ,ὗ,ϋ,ΰ,ῢ,ῧ,ώ,ὼ,ῶ,ὠ,ὤ,ὢ,ὦ,ὡ,ὥ,ὣ,ὧ,ᾳ,ᾴ,ᾲ,ᾷ,ᾀ,ᾄ,ᾂ,ᾆ,ᾁ,ᾅ,ᾃ,ᾇ,ῃ,ῄ,ῂ,ῇ,ᾐ,ᾔ,ᾒ,ᾖ,ᾑ,ᾕ,ᾓ,ᾗ,ῳ,ῴ,ῲ,ῷ,ᾠ,ᾤ,ᾢ,ᾦ,ᾡ,ᾥ,ᾣ,ᾧ,ῤ,ῥ,Ἀ,Ἄ,Ἂ,Ἆ,Ἁ,Ἅ,Ἃ,Ἇ,Ἐ,Ἔ,Ἒ,Ἑ,Ἕ,Ἓ,Ἠ,Ἤ,Ἢ,Ἦ,Ἡ,Ἥ,Ἣ,Ἧ,Ἰ,Ἴ,Ἲ,Ἶ,Ἱ,Ἵ,Ἳ,Ἷ,Ὀ,Ὄ,Ὂ,Ὁ,Ὅ,Ὃ,Ὑ,Ὕ,Ὓ,Ὗ,Ὠ,Ὤ,Ὢ,Ὦ,Ὡ,Ὥ,Ὣ,Ὧ,ᾈ,ᾌ,ᾊ,ᾎ,ᾉ,ᾍ,ᾋ,ᾏ,ᾘ,ᾜ,ᾚ,ᾞ,ᾙ,ᾝ,ᾛ,ᾟ,ᾨ,ᾬ,ᾪ,ᾮ,ᾩ,ᾭ,ᾫ,ᾯ,Ῥ,Α,Β,Γ,Δ,Ε,Ζ,Η,Θ,Ι,Κ,Λ,Μ,Ν,Ξ,Ο,Π,Ρ,Σ,Τ,Υ,Φ,Χ,Ψ,Ω");
$replace = explode(",","ά,ά,ᾶ,ἀ,ἄ,ἄ,ἆ,ἁ,ἅ,ἅ,ἇ,ᾱ,ᾰ,έ,έ,ἐ,ἔ,ἔ,ἑ,ἕ,ἕ,ή,ή,ῆ,ἠ,ἤ,ἤ,ἦ,ἡ,ἥ,ἥ,ἧ,ί,ί,ῖ,ἰ,ἴ,ἴ,ἶ,ἱ,ἵ,ἵ,ἷ,ϊ,ΐ,ΐ,ῗ,ό,ό,ὀ,ὄ,ὄ,ὁ,ὅ,ὅ,ύ,ύ,ῦ,ὐ,ὔ,ὔ,ὖ,ὑ,ὕ,ὕ,ὗ,ϋ,ΰ,ΰ,ῧ,ώ,ώ,ῶ,ὠ,ὤ,ὤ,ὦ,ὡ,ὥ,ὥ,ὧ,ᾳ,ᾴ,ᾴ,ᾷ,ᾀ,ᾄ,ᾄ,ᾆ,ᾁ,ᾅ,ᾅ,ᾇ,ῃ,ῄ,ῄ,ῇ,ᾐ,ᾔ,ᾔ,ᾖ,ᾑ,ᾕ,ᾕ,ᾗ,ῳ,ῴ,ῴ,ῷ,ᾠ,ᾤ,ᾤ,ᾦ,ᾡ,ᾥ,ᾥ,ᾧ,ῤ,ῥ,Ἀ,Ἄ,Ἄ,Ἆ,Ἁ,Ἅ,Ἅ,Ἇ,Ἐ,Ἔ,Ἔ,Ἑ,Ἕ,Ἕ,Ἠ,Ἤ,Ἤ,Ἦ,Ἡ,Ἥ,Ἥ,Ἧ,Ἰ,Ἴ,Ἴ,Ἶ,Ἱ,Ἵ,Ἵ,Ἷ,Ὀ,Ὄ,Ὄ,Ὁ,Ὅ,Ὅ,Ὑ,Ὕ,Ὕ,Ὗ,Ὠ,Ὤ,Ὤ,Ὦ,Ὡ,Ὥ,Ὥ,Ὧ,ᾈ,ᾌ,ᾌ,ᾎ,ᾉ,ᾍ,ᾍ,ᾏ,ᾘ,ᾜ,ᾜ,ᾞ,ᾙ,ᾝ,ᾝ,ᾟ,ᾨ,ᾬ,ᾬ,ᾮ,ᾩ,ᾭ,ᾭ,ᾯ,Ῥ,Α,Β,Γ,Δ,Ε,Ζ,Η,Θ,Ι,Κ,Λ,Μ,Ν,Ξ,Ο,Π,Ρ,Σ,Τ,Υ,Φ,Χ,Ψ,Ω");


$new_content = str_replace($search, $replace, $content); 			// Removes diacritics
$new_content = preg_replace('/(.*?)(-\s)/', '\1', $new_content); 			// Removes excessive whitespace?
$new_content = preg_replace("/\s+/", " ", $new_content);			// Removes line breaks
$new_content = mb_strtolower($new_content, 'UTF-8');


// Put new content in file
file_put_contents($new_file, $new_content);
echo $new_content;

?> 
