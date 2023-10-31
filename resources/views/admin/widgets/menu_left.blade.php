<?php
    $currentUser = Auth::user();
    $oMenus = \App\Menu::orderBy('sort_number', 'ASC')->get();
    $oRole = \App\Role::find($currentUser->roleID);
?>
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!-- User -->
        <div class="user-box">
            <div class="user-img">
                <?php if ($currentUser->roleID == 1) : ?>
                    <?php if ($currentUser->avatar == 'avatar.png') : ?>
                        <a href="<?= route('admin_users_edit', [$currentUser->userID]); ?>">
                            <img src="<?= url('/uploads/users/avatar.png'); ?>" alt="<?= $currentUser->name; ?>" title="<?= $currentUser->name; ?>" class="img-circle img-thumbnail img-responsive">
                        </a>
                    <?php else : ?>
                        <a href="<?= route('admin_users_edit', [$currentUser->userID]); ?>">
                            <img src="<?= url('/uploads/users/' . $currentUser->avatar); ?>" alt="<?= $currentUser->name; ?>" title="<?= $currentUser->name; ?>" class="img-circle img-thumbnail img-responsive">
                        </a>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if ($currentUser->avatar == 'avatar.png') : ?>
                        <img src="<?= url('/uploads/users/avatar.png'); ?>" alt="<?= $currentUser->name; ?>" title="<?= $currentUser->name; ?>" class="img-circle img-thumbnail img-responsive">
                    <?php else : ?>
                        <img src="<?= url('/uploads/users/' . $currentUser->avatar); ?>" alt="<?= $currentUser->name; ?>" title="<?= $currentUser->name; ?>" class="img-circle img-thumbnail img-responsive">
                    <?php endif; ?>
                <?php endif; ?>
                <div class="user-status online"><i class="zmdi zmdi-dot-circle"></i></div>
            </div>
            <h5><?= $currentUser->name; ?> </h5>
            <ul class="list-inline">
                <li>
                    <a href="<?= url('/logout'); ?>" class="text-custom">
                        <i class="zmdi zmdi-power"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End User -->
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <li class="text-muted menu-title">Навигация</li>
                <li>
                    <?php Request::route()->getName() == 'admin_dashboard' ? $activeMenu = 'active': $activeMenu = ''; ?>
                    <a href="<?= route('admin_dashboard'); ?>" class="waves-effect <?= $activeMenu; ?>">
                        <i class="zmdi zmdi-view-dashboard"></i>
                        <span>Главная</span>
                    </a>
                </li>
                <?php
                    $arrMenusIDs = explode(',', $oRole->menusIDs);
                ?>
                <?php foreach ($oMenus as $menu) : ?>
                    <?php if (in_array($menu->menuID, $arrMenusIDs)) : ?>
                        <?php if ($menu->sub == false) : ?>
                            <?php Request::route()->getName() == $menu->route ? $activeMenu = 'active': $activeMenu = ''; ?>
                            <li>
                                <a href="<?= route($menu->route); ?>" class="waves-effect <?= $activeMenu; ?>">
                                    <i class="zmdi <?= $menu->icon; ?>"></i>
                                    <span><?= $menu->name; ?></span>
                                </a>
                            </li>
                        <?php else : ?>
                            <?php
                                $oMenuItems = \App\MenuItem::where('menuID', $menu->menuID)->get();
                                $arrRoutes = [];
                                foreach ($oMenuItems as $item) {
                                    $arrRoutes[] = $item->route;
                                }
                                in_array(Request::route()->getName(), $arrRoutes) ? $activeSub = 'active' : $activeSub = '';
                            ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect <?= $activeSub; ?>">
                                    <i class="zmdi <?= $menu->icon; ?>"></i>
                                    <span><?= $menu->name; ?></span>
                                    <?php if ($menu->menuID == 1) : ?>
                                        <span class="label label-warning pull-right" style="margin-right: 15px">
                                            <?= \App\Quest::all()->count(); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul class="list-unstyled">
                                    <?php foreach ($oMenuItems as $item) : ?>
                                        <?php Request::route()->getName() == $item->route ? $activeItem = 'active' : $activeItem = ''; ?>
                                        <li class="<?= $activeItem; ?>"><a href="<?= route($item->route); ?>"><?= $item->name; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <div class="clearfix"></div>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
</div>