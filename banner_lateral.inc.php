<?php
require_once 'wcm/model/banner_lateral.class.php';
$objBd = new BancodeDados();
$objBannerLateral = new BannerLateral();

foreach ($objBannerLateral->listarBanners() as $banner) {
	echo '<img src="banner_lateral/'.$banner->getName().'" data-thumb="banner_lateral/'.$banner->getName().'" alt="" />';
}
?>