<?php
use yii\helpers\Url;
?>
<!--[if lt IE 9]>
<div class="ie_alert_message">
    <div class="container">
        <div class="on_the_sides">
            <div class="left_side">
                <i class="icon-attention-5"></i> <span class="bold">Attention!</span> This page may not display
                correctly. You are using an outdated version of Internet Explorer. For a faster, safer browsing
                experience.</span>
            </div>
            <div class="right_side">
                <a target="_blank"
                   href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode"
                   class="button_black">Update Now!</a>
            </div>
        </div>
    </div>
</div>
<![endif]-->

<div class="wide_layout">
<header id="header" class="type_6" style="padding-bottom: 0px;">
<div class="top_part">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-8">
            	<?php if(!Yii::$app->user->isGuest):?>
            		<p><a href="<?=Url::to(['user/index'])?>"><?=Yii::$app->user->identity->username?></a> <a href="<?=Url::to(['site/logout'])?>" data-method="post">退出</a></p>
            	<?php else:?>
            		<p><a href="<?=Url::to(['site/login'])?>">登录</a> <a href="<?=Url::to(['site/signup'])?>">注册</a></p>
            	<?php endif;?>
                    
            
            </div>

            <div class="col-lg-4 col-md-5 col-sm-4">
                <div class="clearfix">
                    <div class="alignright site_settings">
                        <span class="current open_"><img src="/statics/images/test/flag_en.jpg" alt="">简体中文</span>
                        <ul class="dropdown site_setting_list language">
                            <li class="animated_item" style="transition-delay:0.1s">
                            	<a href="<?=langurl('zh-CN')?>"><img src="/statics/images/test/flag_en.jpg" alt="">简体中文</a>
                            </li>
                            <li class="animated_item" style="transition-delay:0.1s">
                            	<a href="<?=langurl('en')?>"><img src="/statics/images/test/flag_en.jpg" alt="">English</a>
                            </li>
                        </ul>
                    </div>

                    <!-- <div class="alignright site_settings currency">
                        <span class="current open_">USD</span>
                        <ul class="dropdown site_setting_list">
                            <li class="animated_item" style="transition-delay:0.1s"><a href="#">USD</a></li>
                            <li class="animated_item" style="transition-delay:0.2s"><a href="#">EUR</a></li>
                            <li class="animated_item" style="transition-delay:0.3s"><a href="#">GBP</a></li>
                        </ul>
                    </div> -->

                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="bottom_part">
    <div class="container">
        <div class="row">
            <div class="main_header_row">
                <div class="col-sm-3">
                    <a href="<?=Url::to(['/site/index'])?>" class="logo">
                        <img src="/statics/images/test/logo.png" alt="">
                    </a>
                </div>
                <div class="col-sm-3">
                    <div class="call_us">
                        <span>Call us toll free:</span> <b>+13437202913</b>
                    </div>
                </div>
                <div class="col-sm-6">
                    <form class="clearfix search">
                        <input type="text" name="" tabindex="1" placeholder="搜索..." class="alignleft">
                        <div class="search_category alignleft">
                            <div class="open_categories">全部分类</div>
                            <ul class="categories_list dropdown">
                            	<?php foreach(Yii::$app->params['goodsCategory'] as $k => $v):?>
                                <li class="animated_item"><a href="#"><?=$v['cat_name']?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <button class="button_blue def_icon_btn alignleft"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="main_navigation_wrap" class="sticky_initialized">
<div class="container">
<div class="row">
<div class="col-xs-12">
<!-------------- Sticky container ------------------>
<div class="sticky_inner type_2">
<!-------------- Navigation item ------------------>
<div class="nav_item size_4">
	<button class="open_menu"></button>
	<ul class="theme_menu cats dropdown">
		<?php foreach(Yii::$app->params['goodsCategory'] as $k => $v):?>
			<li class="has_megamenu animated_item">
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
</div>

<div class="nav_item">
    <nav class="main_navigation">
        <ul>
			<li><a href="<?=Url::to(['/site/index'])?>">首页</a></li>
			<?php foreach(Yii::$app->params['goodsCategory'] as $k => $v):?>
			<li><a href="#"><?= (strlen($v['cat_name']) > 12)?(mb_substr($v['cat_name'], 0, 5, 'utf-8').'..'):$v['cat_name'];?></a></li>
			<?php endforeach;?>
        </ul>
    </nav>
</div>
<div class="nav_item size_4">
    <a href="#" class="wishlist_button count-wishlist" data-amount="0"></a>
</div>
<div class="nav_item size_4" id="compare">
    <a href="#" class="compare_button count-compare" id="countCompare" data-amount="3"></a>
</div>

<div class="nav_item size_3">
    <button id="open_shopping_cart" class="open_button" data-amount="3">
        <b class="title">My Cart</b>
        <b class="total_price">$999.00</b>
    </button>
    <div class="shopping_cart dropdown">
        <div class="animated_item" style="transition-delay:0.1s">
            <p class="title">Recently added item(s)</p>
            <div class="clearfix sc_product">
                <a href="#" class="product_thumb"><img src="/statics/images/test/sc_img_1.jpg" alt=""></a>
                <a href="#" class="product_name">Natural Factors PGX Daily Ultra Matrix...</a>
                <p>1 x $499.00</p>
                <button class="close"></button>
            </div>
        </div>
        <div class="animated_item" style="transition-delay:0.2s">
            <div class="clearfix sc_product">
                <a href="#" class="product_thumb"><img src="/statics/images/test/sc_img_2.jpg" alt=""></a>
                <a href="#" class="product_name">Oral-B Glide Pro-Health Floss...</a>
                <p>1 x $499.00</p>
                <button class="close"></button>
            </div>
        </div>
        <div class="animated_item" style="transition-delay:0.3s">
            <div class="clearfix sc_product">
                <a href="#" class="product_thumb"><img src="/statics/images/test/sc_img_3.jpg" alt=""></a>

                <a href="#" class="product_name">Culturelle Kids! Probi-<br>otic Packets 30 ea</a>

                <p>1 x $499.00</p>

                <button class="close"></button>

            </div>
            <!--/ .clearfix.sc_product-->

            <!-------------- End of product ------------------>

        </div>
        <!--/ .animated_item-->

        <div class="animated_item" style="transition-delay:0.4s">

            <!-------------- Total info ------------------>

            <ul class="total_info">

                <li><span class="price">Tax:</span> $0.00</li>

                <li><span class="price">Discount:</span> $37.00</li>

                <li class="total"><b><span class="price">Total:</span> $999.00</b></li>

            </ul>

            <!-------------- End of total info ------------------>

        </div>
        <!--/ .animated_item-->

        <div class="animated_item" style="transition-delay:0.5s">

            <a href="cart/cart/index" class="button_grey">View Cart</a>

            <a href="#" class="button_blue">Checkout</a>

        </div>
        <!--/ .animated_item-->

    </div>
    <!--/ .shopping_cart.dropdown-->

    <!-------------- End of products list ------------------>

</div>
<!--/ .nav_item-->

<!-------------- End of navigation item ------------------>

</div>
<!--/ .sticky_inner -->

<!-------------- End of sticky container ------------------>

</div>
<!--/ [col]-->

</div>
<!--/ .row-->

</div>
<!--/ .container-->

</div>
<!--/ .main_navigation_wrap-->

<!-------------- End of main navigation wrapper ------------------>

</header>