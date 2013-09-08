﻿<?php 




$author = "homer";

$dir = '/Users/Michael/Dropbox/Filologi/Workspace/Projects/kardinaldyderne/ordstudier/Corpora/'.$author;
$works = count(glob($dir . "/*"));

$works = 2;

function renameFiles($directory) {
	$handler = opendir($directory) or die("Invalid Directory");
	while ($file = readdir($handler)) {
		if ($file != "." && $file != "..") {
			$newName = preg_replace('/(-00|-0)/','-',$file);
			rename($directory.DIRECTORY_SEPARATOR.$file,$directory.DIRECTORY_SEPARATOR.$newName);
		}
	}
// clean up
closedir($handler);
}
renameFiles($dir);
if(file_get_contents($dir.DIRECTORY_SEPARATOR.$author."-1.txt")) {
	$temp_dir = $dir.DIRECTORY_SEPARATOR.$author."-1.txt";
	$content = "[1] {Work} " . file_get_contents($temp_dir);
}

for($i=02; $i<$works+1; $i++){
	$file = $dir.DIRECTORY_SEPARATOR.$author."-".$i.".txt";
	if(file_get_contents($file)) {
		$content .= "[$i] {Work}" . file_get_contents($file);
	}
}



$search =  explode(",","ά,ὰ,ᾶ,ἀ,ἄ,ἂ,ἆ,ἁ,ἅ,ἃ,ἇ,ᾱ,ᾰ,έ,ὲ,ἐ,ἔ,ἒ,ἑ,ἕ,ἓ,ή,ὴ,ῆ,ἠ,ἤ,ἢ,ἦ,ἡ,ἥ,ἣ,ἧ,ί,ὶ,ῖ,ἰ,ἴ,ἲ,ἶ,ἱ,ἵ,ἳ,ἷ,ϊ,ΐ,ῒ,ῗ,ό,ὸ,ὀ,ὄ,ὂ,ὁ,ὅ,ὃ,ύ,ὺ,ῦ,ὐ,ὔ,ὒ,ὖ,ὑ,ὕ,ὓ,ὗ,ϋ,ΰ,ῢ,ῧ,ώ,ὼ,ῶ,ὠ,ὤ,ὢ,ὦ,ὡ,ὥ,ὣ,ὧ,ᾳ,ᾴ,ᾲ,ᾷ,ᾀ,ᾄ,ᾂ,ᾆ,ᾁ,ᾅ,ᾃ,ᾇ,ῃ,ῄ,ῂ,ῇ,ᾐ,ᾔ,ᾒ,ᾖ,ᾑ,ᾕ,ᾓ,ᾗ,ῳ,ῴ,ῲ,ῷ,ᾠ,ᾤ,ᾢ,ᾦ,ᾡ,ᾥ,ᾣ,ᾧ,ῤ,ῥ,Ἀ,Ἄ,Ἂ,Ἆ,Ἁ,Ἅ,Ἃ,Ἇ,Ἐ,Ἔ,Ἒ,Ἑ,Ἕ,Ἓ,Ἠ,Ἤ,Ἢ,Ἦ,Ἡ,Ἥ,Ἣ,Ἧ,Ἰ,Ἴ,Ἲ,Ἶ,Ἱ,Ἵ,Ἳ,Ἷ,Ὀ,Ὄ,Ὂ,Ὁ,Ὅ,Ὃ,Ὑ,Ὕ,Ὓ,Ὗ,Ὠ,Ὤ,Ὢ,Ὦ,Ὡ,Ὥ,Ὣ,Ὧ,ᾈ,ᾌ,ᾊ,ᾎ,ᾉ,ᾍ,ᾋ,ᾏ,ᾘ,ᾜ,ᾚ,ᾞ,ᾙ,ᾝ,ᾛ,ᾟ,ᾨ,ᾬ,ᾪ,ᾮ,ᾩ,ᾭ,ᾫ,ᾯ,Ῥ,Α,Β,Γ,Δ,Ε,Ζ,Η,Θ,Ι,Κ,Λ,Μ,Ν,Ξ,Ο,Π,Ρ,Σ,Τ,Υ,Φ,Χ,Ψ,Ω");
$replace = explode(",","α,α,α,α,α,α,α,α,α,α,α,α,α,ε,ε,ε,ε,ε,ε,ε,ε,η,η,η,η,η,η,η,η,η,η,η,ι,ι,ι,ι,ι,ι,ι,ι,ι,ι,ι,ι,ι,ι,ι,ο,ο,ο,ο,ο,ο,ο,ο,υ,υ,υ,υ,υ,υ,υ,υ,υ,υ,υ,υ,υ,υ,υ,ω,ω,ω,ω,ω,ω,ω,ω,ω,ω,ω,αι,αι,αι,αι,αι,αι,αι,αι,αι,αι,αι,αι,ηι,ηι,ηι,ηι,ηι,ηι,ηι,ηι,ηι,ηι,ηι,ηι,ωι,ωι,ωι,ωι,ωι,ωι,ωι,ωι,ωι,ωι,ωι,ωι,ρ,ρ,α,α,α,α,α,α,α,α,ε,ε,ε,ε,ε,ε,η,η,η,η,η,η,η,η,ι,ι,ι,ι,ι,ι,ι,ι,ο,ο,ο,ο,ο,ο,υ,υ,υ,υ,ω,ω,ω,ω,ω,ω,ω,ω,αι,αι,αι,αι,αι,αι,αι,αι,ηι,ηι,ηι,ηι,ηι,ηι,ηι,ηι,ωι,ωι,ωι,ωι,ωι,ωι,ωι,ωι,ρ,α,β,γ,δ,ε,ζ,η,θ,ι,κ,λ,μ,ν,ξ,ο,π,ρ,σ,τ,υ,φ,χ,ψ,ω");
//$new_contents = str_replace($search, $replace, $content); 			// Removes diacritics
$new_contents = preg_replace('/(.*?)(-\s)/', '\1', $content); 			// Removes excessive whitespace?

//str_replace("\\t"," ", $new_contents);								// Removes tabs

$new_contents = preg_replace("/\s+/", " ", $new_contents);			// Removes line breaks

$dir = $dir.DIRECTORY_SEPARATOR.$author."-dia.txt";
file_put_contents($dir, $new_contents);





echo $new_contents;


?> 