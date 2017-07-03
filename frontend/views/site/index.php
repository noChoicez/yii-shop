<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use common\models\GoodsModel;
$this->title = 'Yii-Shop';

?>



<!-- - - - - - - - - - - - - - Page Wrapper - - - - - - - - - - - - - - - - -->

<div class="secondary_page_wrapper">

    <div class="container">
                <div class="row">

<!-- - - - - - - - - - - - - - Banners - - - - - - - - - - - - - - - - -->

<aside class="col-md-3 col-sm-4 has_mega_menu">
<section class="section_offset animated visible fadeInDown" data-animation="fadeInDown">
<h3 class="widget_title">限时秒杀</h3>
<!-- owl_carousel widgets_carousel  -->
<div class="owl_carousel widgets_carousel owl-carousel">
	<?php for($i = 0; $i<10; $i++):?>
		<div class="product_item">
				    <div class="image_wrap">
				        <img src="" alt="" width="100%" height="200">
				        <div class="actions_wrap">
				            <div class="centered_buttons">
				                <a href="#" class="button_dark_grey middle_btn quick_view" data-modal-url="modals/quick_view.html">Quick View</a>
				                <a href="#" class="button_blue middle_btn add_to_cart">Add to Cart</a>
				            </div>
				            <a href="#" class="button_dark_grey middle_btn def_icon_btn add_to_wishlist tooltip_container"><span class="tooltip right">Add to Wishlist</span></a>
				            <a href="#" class="button_dark_grey middle_btn def_icon_btn add_to_compare tooltip_container"><span class="tooltip left">Add to Compare</span></a>
				        </div>
				    </div>
				    <div class="label_offer percentage">
				        <div>25%</div>OFF
				    </div>
				    <div class="countdown is-countdown" data-year="2016" data-month="2" data-day="9" data-hours="10" data-minutes="30" data-seconds="30"><span class="countdown-row countdown-show3"><span class="countdown-section"><span class="countdown-amount">0</span><span class="countdown-period">hours</span></span><span class="countdown-section"><span class="countdown-amount">0</span><span class="countdown-period">min</span></span><span class="countdown-section"><span class="countdown-amount">0</span><span class="countdown-period">sec</span></span></span>
				    </div>
				    <div class="description">
				        <p><a href="#">Ipsum with Ultra Dolor, Size 4 Diapers 29 ea</a></p>
				        <div class="clearfix product_info">
				            <ul class="rating alignright">
				                <li class="active"></li>
				                <li class="active"></li>
				                <li class="active"></li>
				                <li class="active"></li>
				                <li class="active"></li>
				            </ul>
				            <p class="product_price alignleft"><s>$16.99</s> <b>$14.99</b></p>
				        </div>
				    </div>
				</div>
	<?php endfor;?> 
				

</div>


<footer class="bottom_box">

    <a href="#" class="button_grey middle_btn">View All Deals</a>

</footer>

<!-- - - - - - - - - - - - - - End of view all deals of the day - - - - - - - - - - - - - - - - -->

</section><!--/ .section_offset.animated.transparent-->

<!-- - - - - - - - - - - - - - End of today's deals - - - - - - - - - - - - - - - - -->

<!-- - - - - - - - - - - - - - Categories - - - - - - - - - - - - - - - - -->

<section class="section_offset animated transparent" data-animation="fadeInDown">

	<h3>产品分类</h3>
	<ul class="theme_menu cats">
		<?php foreach(Yii::$app->params['goodsCategory'] as $k => $v):?>
			<li class="has_megamenu">
			    <a href="#"><?=$v['cat_name']?>(<?=count($v['child'])?>)</a>
			    <?php if(isset($v['child'])):?>
				    <div class="mega_menu clearfix">
				        <div class="mega_menu_item">
				            <ul class="list_of_links">
				                <?php foreach($v['child'] as $kk => $vv):?>
				                	<li><a href="#"><?=$vv['cat_name']?></a></li>
				                <?php endforeach;?>
				            </ul>
				        </div>
				    </div>
			    <?php endif;?>
			</li>
		<?php endforeach;?>
	</ul>
	
</section>

<div class="section_offset animated transparent" data-animation="fadeInDown">
    <a href="#">
        <img src="/statics/images/test/banner_img_10.png" alt="">
    </a>
</div>

<section class="section_offset animated transparent" data-animation="fadeInDown">

    <h3>Testimonials</h3>
    <div class="owl_carousel widgets_carousel owl-carousel single_visible_element owl-loaded">
	    <?php for($i = 0; $i<10; $i++):?>
	    <div class="cloned">
	    	<blockquote>
	            <div class="author_info"><b>Tracy, New York</b></div>
	            <p>Donec sit amet eros. Lorem ipsum dolor sit amet elit. Mauris amet fermentum dictum magna. Sed laoreet aliquam leo. Ut tellus dolor, dapibus eget.</p>
	        </blockquote>
	     </div>
		<?php endfor;?> 
	</div>
	
    <footer class="bottom_box">
        <a href="#" class="button_grey middle_btn">View All Testimonials</a>
    </footer>

</section>

<section class="section_offset animated transparent" data-animation="fadeInDown">
    <h3>Bestseller Products</h3>
    <ul class="products_list_widget">
		<?php for($i = 0 ; $i <10; $i++):?>
        <li>
            <a href="#" class="product_thumb">
                <img src="/statics/images/test/product_thumb_6.jpg" alt="">
            </a>
            <div class="wrapper">
                <a href="#" class="product_title">Ut Tellus  Dolor Dapibus Eget...</a>
                <div class="clearfix product_info">
                    <p class="product_price alignleft"><b>$76.99</b></p>
                    <ul class="rating alignright">
                        <li class="active"></li>
                        <li class="active"></li>
                        <li class="active"></li>
                        <li class="active"></li>
                        <li class="active"></li>
                    </ul>
                </div>
            </div>
        </li>
        <?php endfor;?>
    </ul>
    <footer class="bottom_box">
        <a href="#" class="button_grey middle_btn">View All</a>
    </footer>
</section>

<div class="section_offset animated transparent" data-animation="fadeInDown">
    <a href="#">
        <img src="/statics/images/test/banner_img_11.png" alt="">
    </a>
</div>

<section class="section_offset animated transparent" data-animation="fadeInDown">

    <h3>On Sale Products</h3>

    <ul class="products_list_widget">
		<?php for($i = 0 ; $i <10; $i++):?>
        <li>
            <a href="#" class="product_thumb">
                <img src="/statics/images/test/product_thumb_10.jpg" alt="">
            </a>
            <div class="wrapper">
                <a href="#" class="product_title">Lorem Ipsum Dolor Sit Amet...</a>
                <div class="clearfix product_info">
                    <p class="product_price alignleft"><s>$19.99</s> <b>$13.99</b></p>
                </div>
            </div>
        </li>
		<?php endfor;?>
    </ul>
    <footer class="bottom_box">
        <a href="#" class="button_grey middle_btn">View All</a>
    </footer>
</section>

<section class="section_offset animated transparent" data-animation="fadeInDown">
    <h3>Sign Up to Our Newsletter</h3>
    <div class="theme_box">
        <p class="form_caption">Sing up to our newsletter and get exclusive deals you wont find any- where else straight to your inbox!</p>
        <form class="newsletter subscribe clearfix" novalidate="">
            <input type="email" name="sc_email" placeholder="Enter your email address">
            <button class="button_blue def_icon_btn"></button>
        </form>
    </div>
</section>

</aside>

<main class="col-md-9 col-sm-8">

<section class="section_offset">
	<div class="swiper-container">
	    <div class="swiper-wrapper">
	        <div class="swiper-slide"><img src="http://img1.xiazaizhijia.com/walls/20150721/mid_5d8830739233940.jpg" width="100%"></div>
	        <div class="swiper-slide"><img src="http://img1.xiazaizhijia.com/walls/20150721/mid_5d8830739233940.jpg" width="100%"></div>
	        <div class="swiper-slide"><img src="http://img1.xiazaizhijia.com/walls/20150721/mid_5d8830739233940.jpg" width="100%"></div>
	    </div>
	    <!-- 如果需要分页器 -->
	    <div class="swiper-pagination"></div>
	    
	    <!-- 如果需要导航按钮 -->
	    <div class="swiper-button-prev"></div>
	    <div class="swiper-button-next"></div>
	    
	    <!-- 如果需要滚动条 -->
	    <!-- <div class="swiper-scrollbar"></div> -->
	</div>
</section>

<section class="section_offset">
    <div class="row">
        <div class="col-sm-6">
            <a href="#" class="banner animated transparent" data-animation="fadeInDown">
                <img src="/statics/images/test/banner_img_1.jpg" alt="">
            </a>
        </div>
        <div class="col-sm-6">
            <a href="#" class="banner animated transparent" data-animation="fadeInDown" data-animation-delay="150">
                <img src="/statics/images/test/banner_img_2.jpg" alt="">
            </a>
        </div>
    </div>
</section>

<?php 

foreach(Yii::$app->params['goodsCategory'] as $k => $v):
$allGoods[$k] = GoodsModel::getGoodsByGoodsCategory($v['id'],1);
$allGoods[$k] = array_filter($allGoods[$k]);
if(isset($allGoods[$k]) && count($allGoods[$k]) > 0):
?>
<section class="section_offset animated transparent" data-animation="fadeInDown">
	<h3><?=$v['cat_name']?></h3>
	<div class="tabs type_2 products initialized many_tabs">
		<ul class="tabs_nav clearfix">
			<?php 
				$i=0;
				foreach($v['child'] as $kk => $vv):
				$goods[$kk] = GoodsModel::getGoodsByGoodsCategory($vv['id']);
				if($i <= 8 && (count($goods[$kk]) > 0)):
			?>
		    <li class="<?=($i == 0)?'active':''?>"><a href="#tab-<?=$vv['id']?>"><?=$vv['cat_name']?></a></li>
		    <?php endif;?>
		    <?php $i++;endforeach;?>
		</ul>
		<div class="tab_containers_wrap">
			<?php 
			$goods = array_filter($goods);
			foreach($v['child'] as $kk => $vv):
			if(isset($goods[$kk]) && count($goods[$kk]) > 0):
			?>
				<div id="tab-<?=$vv['id']?>" class="tab_container">
					<div class="owl_carousel carousel_in_tabs owl-carousel owl-theme owl-loaded">
						<?php foreach($goods[$kk] as $k => $v):?>
							<div class="product_item type_2">
							    <div class="image_wrap">
							        <img src="http://admin.yii-shop.info/<?=$v['goods_image']??''?>" alt="">
							        <div class="actions_wrap">
							            <div class="centered_buttons">
							                <a href="#" class="button_dark_grey middle_btn quick_view" data-modal-url="<?=Url::to(['site/index'])?>">Quick View</a>
							            </div>
							        </div>
							    </div>
							    <div class="label_new">New</div>
							    <div class="description">
							        <a href="#"><?=$v['goods_name']?></a>
							        <div class="clearfix product_info">
							            <p class="product_price alignleft"><b>￥<?=$v['shop_price']?:'0.00'?></b></p>
							        </div>
							    </div>
							    <div class="buttons_row">
							        <button class="button_blue middle_btn">Add to Cart</button>
							        <button class="button_dark_grey middle_btn def_icon_btn add_to_wishlist tooltip_container"><span class="tooltip top">Add to Wishlist</span></button>
							        <button class="button_dark_grey middle_btn def_icon_btn add_to_compare tooltip_container"><span class="tooltip top">Add to Compare</span></button>
							    </div>
							</div>
						<?php endforeach;?>
					</div>
					<footer class="bottom_box">
					    <a href="#" class="button_grey middle_btn">View All Products</a>
					</footer>
				</div>
			<?php endif;endforeach;?>
		</div>
	</div>

</section>

<?php endif; endforeach;?>

</main>


</div>
    </div>

</div>


