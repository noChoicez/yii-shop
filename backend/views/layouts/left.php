<?php 
use mdm\admin\components\MenuHelper;
use mdm\admin\models\Menu;
$callback = function($menu){
    $data = json_decode($menu['data'],true);
    return [
        'label' => $menu['name'],
        'url' => [$menu['route']],
        'icon' => $data['icon'],
        'items' => $menu['children']
    ];
};
$items = MenuHelper::getAssignedMenu(Yii::$app->user->id,'',$callback);
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
            	'items' => $items,
            ]
        ) ?>

    </section>

</aside>
