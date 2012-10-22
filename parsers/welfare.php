<?php
//define("PATH", '../');
//include(PATH.'place_settings.cfg');
include('/home/vsempzp/public_html/'.'place_settings.cfg');
include(PATH.'settings.cfg');
//--------------

include(PATH.'libs/_error.php');

include(PATH.'libs/_db.php');
$DB = new DataBase();

include (PATH.'libs/timage.php');
$IMAGE = new ImageResizer($DB);

include (PATH.'libs/products.php');

include (PATH.'libs/Snoopy.php');

include (PATH.'libs/functions.php');

class welfareParser extends IntegratedDataBase{
    private $vendor_id = 2;
    private $URL = "http://welfare.ua";
    private $categories = array(
                "female-shoes/ballet-flats"         => 57, 
                "female-shoes/sandals"              => 58,
                "female-shoes/knee-high-boots"      => 59,
                "female-shoes/boots"                => 60,
                "female-shoes/moccasins"            => 61,
                "female-shoes/half-high-boots"      => 62,
                "female-shoes/clogs"                => 63,
                "female-shoes/high-boots"           => 64,
                "female-shoes/shoes"                => 65,
                "male-shoes/m-boots"                => 66,
                "male-shoes/m-moccasins"            => 67,
                "male-shoes/m-half-boots"           => 68,
                "male-shoes/m-clogs"                => 69,
                "male-shoes/m-sandals"              => 70,
                "male-shoes/m-shoes"                => 71,
                "belts"                             => 72,
                "bags/women"                        => 73,
                "bags/men"                          => 74,
                "bags/unisex"                       => 73,
                "bags/unisex"                       => 74,
                "scarves"                           => 37
        );
    
    public function getAll() {
        
        foreach ($this->categories as $category=>$id) {
            $result = $this->getCat($category, $id);
        }
    }
    
    public function getCat($cat, $id) {
        
        $last_update = $this->DB->ReadAssRow("select * from vendor_last_update where vendor_url = '$cat' and vendor_id={$this->vendor_id}");
        if ($last_update && time()-DAY<$last_update['update_date']) {
            return;
        }
        
        $SN = new Snoopy();
        $page = 1;
        
        do {
          echo $this->URL . '/' . $cat . '?page=' . $page;
          $SN->fetch($this->URL . '/' . $cat . '?page=' . $page);
          preg_match_all('/<table class="one">[^<]*<tr>[^<]*<td colspan="2"><a href="([^"]*)"/', $SN->results, $goods);
          $goods = $goods[1];

          foreach ((array)$goods as $good) {
              echo '<br>'.$good.'<br>';
              $this->getGood($good, $id, $cat);
          }
          
          $page++;
        } while (!empty($goods));
        
        if ($last_update) {
              $last_update['update_date'] = time();
              $this->DB->EditDB($last_update, 'vendor_last_update', "id={$last_update['id']}");
              
        } else {
            $last_update['update_date'] = time();
            $last_update['vendor_id'] = $this->vendor_id;
            $last_update['vendor_url'] = $cat;
            $this->DB->EditDB($last_update, 'vendor_last_update');
            
        }

        $this->DB->EditDB(array('good_check'=>0), 'goods', "last_update<".(time()-DAY)." AND vendor_cat='$cat'");
    }
    
    public function getGood($good, $cat, $cat_url) {
        global $Global;
        
        $SN = new Snoopy();
        $SN->fetch($good);
        
        $tmp = $SN->results;
       
        $text = GetBetween('<a class="call_us">', '<div class="footer"', $tmp);
        $result = array('good_uri'=>$good);
                
        $result['good_name'] =(GetBetween('<h1>', '</h1>', $text));
        $result['good_name'] = explode('&', $result['good_name'], 2);
        $result['good_name'] = $result['good_name'][0];
        if (!$result['good_name']) return;
        
        $img = GetBetween('<div class="small">', '</div>', $text);
        preg_match_all('/<a[^>]*href="([^"]*)"/',$img, $matches);
        $images = $matches[1];
        
        $result['good_price'] = trim(strip_tags(GetBetween('<div class="price large">', '</div>', $text)));
        $result['good_price'] = str_replace(array(' ', ','), array('', ''), $result['good_price']);
        
        $result['good_sizes'] = GetBetween('id="size_table"', '</table>', $text);
        preg_match_all('/<a[^>]*>([^<]*)<\\/a>/',$result['good_sizes'], $matches);
        $result['good_sizes'] = implode(', ', $matches[1]);
        
        
       
        $tmp = GetBetween('<div class="harackteristics">', '</div>', $text);
        $result['good_desc'] = GetBetween('</span>', '</table>', $tmp).'</table>';
        
        $tmp = $result['good_desc'];
        $result['good_man'] = strip_tags(GetBetween('Производитель</td>', '</td>', $tmp));
        
        $tmp = $result['good_desc'];
        $tmp2 = GetBetween('id="product_articul"', '/td>', $tmp);
        $result['good_art'] = GetBetween('>', '<', $tmp2);
        
        $result['vendor_id'] = $this->vendor_id;
        $result['last_update'] = time();
        $result['vendor_cat'] = $cat_url;
        
        Product::addFromParsers($result, $images, $this->vendor_id, $cat);
        
        sleep(1);
    }
    
}

$parser = new welfareParser($DB);
echo $parser->getAll();