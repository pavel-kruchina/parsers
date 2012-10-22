<style type="text/css">
body { background-color: #FFFFFF; font-family: Arial; color: #000000; font-size: 13px; }
a:link, a:active, a:visited { color: #345342; text-decoration: underline; }
a:hover { color: #FF0000; text-decoration: none; }
</style>

<!-- ����� �� ������ ���������� ����� ���� ��������. -->

<h3 align=center>����� �����</h3>
<? class filter {  var $files_reg = Array(); var $dirs_reg = Array();  function filter() { $this->add_dir("."); $this->add_dir(".."); }  function add_file($name) { $this->files_reg[]='/^'.$name.'$/'; }  function add_dir($name) { $this->dirs_reg[]='/^'.$name.'$/'; } function add_extension($name) { $this->files_reg[]='/^.*\.'.$name.'$/'; } function add_file_reg($reg) { $this->files_reg[]=$reg; } function add_dir_reg($reg) { $this->dirs_reg[]=$reg; }  function in_file_filter($name) { foreach($this->files_reg as $reg) { if (@preg_match($reg,$name)) return true; } return false; } function in_dir_filter($name) { foreach($this->dirs_reg as $reg) { if (@preg_match($reg,$name)) return true; } return false; } }  class Dir {  var $dirs; var $files;  function Dir($wd, $filter) { $cwd = getcwd(); if(!@chdir($wd)) return false;  if(!($handle = @opendir("."))) return false;  while ($file = readdir($handle)) { if(is_dir($file) &&  !$filter->in_dir_filter($file)) { $this->dirs[] = $file; } else if(is_file($file) &&  !$filter->in_file_filter($file)) {  $this->files[] = $file;  } } chdir($cwd); }  function is_empty() { if(!is_array($this->dirs) && !is_array($this->files)) return true; return false; }  function get_dirs() { if(is_array($this->dirs)) sort($this->dirs); return $this->dirs; } function get_files() { if(is_array($this->files)) sort($this->files); return $this->files; } }  class maphp {  var $empty_dirs;  var $filter;  function maphp($filter=null) { $this->show_empty_dirs(false); if(null==$filter) $this->set_filter(new filter()); }  function show_empty_dirs($bool) { $this->empty_dirs=$bool; }  function set_filter($filter) { $this->filter=$filter; } function encode_path($path) { $tmp = explode("/",$path); for($i=0;$i<count($tmp);$i++) { $tmp[$i]=rawurlencode($tmp[$i]); } return implode("/",$tmp); }  function scan_files($path,$afiles) { if(is_array($afiles)) { foreach($afiles as $cur) {  $fsize = filesize("$path/$cur")/1024; $fsize = round($fsize,2); $upath = $this->encode_path($path);  $text = file_get_contents("$path/$cur"); $textt = preg_match("#\<title>(.+?)\</title>#s",$text,$s); $result = trim($s[1]);  $upp = "<li><a href=$upath/$cur>$result</a> (������: $fsize Kb)</li>\n";  if (!preg_match('/htm/',$upp) && !preg_match('/html/',$upp)) { $upp = ""; }  echo "$upp";  } } }  function scan_dirs($path,$adirs) { if(is_array($adirs)) { foreach($adirs as $cur) {  $d = new Dir("$path/$cur",$this->filter); if($d->is_empty() && !$this->empty_dirs) continue;  $items = count($d->get_dirs()) + count($d->get_files());  $upath = $this->encode_path($path);  echo "<li>\n"; echo "<b>������ �����</b> (�����: $cur - $items ������)\n"; echo "<ol>\n";  $this->scan("$cur","$path/$cur");  echo "</ol>\n"; echo "</li>\n"; } } }  function scan($dir=".",$path=".") { $directory = new Dir($path,$this->filter); if(!$directory) return false;  $adirs = $directory->get_dirs(); $afiles = $directory->get_files();  $this->scan_dirs($path,$adirs);  $this->scan_files($path,$afiles); }  function run($path=".") { echo "<ul>"; echo "<li>"; echo "<a href=http://"; echo $_SERVER['HTTP_HOST']; echo ">"; echo "������� ��������"; echo "</a><a href=http://youryoga.org></a>"; echo "<ul>";  if (is_dir($path)) { $d = new Dir($path,$this->filter); if($d && !$d->is_empty())  $this->scan($path,$path); else echo "����� �����."; } else { echo "<b class=\"error\">����� �����. ������.</b>"; }  echo " </ul>"; echo " </li>"; echo "</ul>"; } } $cwd = basename(getcwd()); $filter=new filter(); $filter->add_dir($cwd); $filter->add_dir_reg("/^\..*$/"); $filter->add_extension("inc"); $filter->add_file_reg("/^\..*$/"); $filter->add_file_reg("/^.*~$/"); $explorer = new maphp();  $explorer->set_filter($filter); $explorer->run(".."); ?>

<p><small><a href=http://youryoga.org>����� ������� ��</a></small></p>

<!-- ����� �� ������ ���������� ����� ��� ��������. -->