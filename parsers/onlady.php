<?php
include('/home/vsempzp/public_html/'.'place_settings.cfg');
include(PATH.'settings.cfg');
//--------------

include(PATH.'libs/_error.php');

include(PATH.'libs/_db.php');
$DB = new DataBase();

include (PATH.'libs/timage.php');
$IMAGE = new ImageResizer($DB);

include (PATH.'libs/Snoopy.php');

include (PATH.'libs/functions.php');

class onladyParser extends IntegratedDataBase{
    private $vendor_id = 1;
    private $URL = "http://onlady.com.ua";
    private $categories = array(
                "catalog/dresses/short/"        => 30,
                "catalog/dresses/long/"         => 31,
                "catalog/dresses/top/"          => 32,
                "catalog/dresses/corsets/"      => 33,
                "catalog/dresses/tricot/"       => 34,
                "catalog/dresses/office/"       => 35,
                "catalog/dresses/big_dresses/"  => 36,
                "catalog/accessories/"          => 37,
                'catalog/perfumes/woman/'=>39,
                'catalog/perfumes/man/'=>40,
                'catalog/swimwear/swim-2012/'=>41,
                'catalog/swimwear/swim-2011/'=>42,
                'catalog/swimwear/bikini/'=>43,
                'catalog/swimwear/monokini/'=>44,
                'catalog/swimwear/crochet/'=>45,
                'catalog/swimwear/mini/'=>46,
                'catalog/swimwear/plussize/'=>47,
                'catalog/swimwear/beachwear/'=>48,
                'catalog/stocking/tights/'=>49,
                'catalog/stocking/stockings/'=>50,
                'catalog/stocking/socks/'=>51,
                'catalog/stocking/kombinezonyi/'=>52,
                'catalog/stocking/big_kolgotki/'=>53,
                'catalog/stocking/kolgotki-i-chulki-ot-8-do-15-den/'=>54,
                'catalog/present-kit/'=>55,
                'catalog/costumes/'=>56
                
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
        $SN->fetch($this->URL.'/'.$cat);
        preg_match('/<table[^>]*class="cat"[^>]*>(.*)<\\/table>/', $SN->results, $matches);
        preg_match_all('/<div class="space"><a[^>]*href="([^"]*)"/', $matches[1], $goods);
        $goods = $goods[1];
        
        foreach ($goods as $good) {
            echo '<br>'.$good.'<br>';
            $this->getGood($good, $id, $cat);
        }
        
        if ($last_update) {
            $last_update['update_date'] = time();
            $this->DB->EditDB($last_update, 'vendor_last_update', "id={$last_update['id']}");
        } else {
            $last_update['update_date'] = time();
            $last_update['vendor_id'] = $this->vendor_id;
            $last_update['vendor_url'] = $cat;
            $this->DB->EditDB($last_update, 'vendor_last_update');
        }
        
        $this->DB->EditDB(array('good_check'=>0), 'goods', "last_update>".(time()-DAY)." AND vendor_cat='$cat'");
        
    }
    
    public function getGood($good, $cat, $cat_url) {
        global $Global;
        global $IMAGE;
        
        $SN = new Snoopy();
        $SN->fetch($this->URL.$good);
        
        $tmp = $SN->results;
        
        $text = GetBetween('<div id="right_part">', '<div class="order_online">', $tmp);
        
        $result = array('good_uri'=>$this->URL.$good);
        
        $result['good_name'] = GetBetween('<div class="art"><h1>', '</h1>', $text);
        
        if (!$result['good_name']) return;
        
        $result['good_art'] = GetBetween('<i>', '</i>', $text);
        $img = GetBetween('src="', '"', $text);
        $result['good_desc'] = GetBetween('<div class="right">', '<p ', $text);
        $result['good_man'] = strip_tags(GetBetween('class="producer">', '</p>', $text));
        $result['good_sizes'] = GetBetween('class="size">', '</p>', $text);
        $result['good_price'] = GetBetween('<span class="item_price primary" id="curr_block_2"><nobr>', '</nobr>', $text);
        if (!$result['good_price']) {
            $result['good_price'] = GetBetween('</i><nobr>', '</nobr>', $text);
        }
        $result['good_price'] = str_replace(" ", '', $result['good_price']);
        
        $result['vendor_id'] = $this->vendor_id;
        $result['last_update'] = time();
        $result['vendor_cat'] = $cat_url;
        
        $good = $this->DB->ReadScalar("select good_id from goods where vendor_id={$this->vendor_id} and good_art='{$result['good_art']}'");
        if (!$good) {
            $result['sc_id'] = $cat;
            $this->DB->EditDB($result,'goods');
            $ObjectID = $this->DB->LastInserted;
            $this->DB->EditDB(array('good_id'=>$ObjectID, 'sc_id'=>$cat),'goods_x_subcat');
        
            $this->DB->EditDB(array("good_url"=>translit($result['good_name']).'_'.$ObjectID),'goods', "good_id=$ObjectID");


            $SN->fetch($img);
            $str = $SN->results;
            $this->DB->EditDB(array('good_id'=>$ObjectID),'o_photos');
            $OID = $this->DB->LastInserted;
            file_put_contents(PATH.$Global['Foto.Dir'].'/'.$OID.'.jpg', $str);
            $IMAGE->ResizeOutImage(PATH.$Global['Foto.Dir'].'/'.$OID.'.jpg', PATH.$Global['Foto.MinDir'].'/'.$OID.'.jpg', $Global['Foto.MinW'], $Global['Foto.MinH'], 'jpg');
        } else {
            $this->DB->EditDB($result,'goods', 'good_id='.$good);
            $isLink = $this->DB->ReadScalar("select id from goods_x_subcat where good_id=$good and sc_id=$cat");
            if (!$isLink) {
                $this->DB->EditDB(array('good_id'=>$good, 'sc_id'=>$cat),'goods_x_subcat');
            }
        }
        
        
        var_dump($result);
        sleep(1);
    }
    
}

$parser = new onladyParser($DB);
echo $parser->getAll();