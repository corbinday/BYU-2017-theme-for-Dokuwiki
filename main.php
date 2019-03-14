<?php
/**
 * DokuWiki Default Template 2012
 *
 * @link     http://dokuwiki.org/template
 * @author   Anika Henke <anika@selfthinker.org>
 * @author   Clarence Lee <clarencedglee@gmail.com>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
header('X-UA-Compatible: IE=edge,chrome=1');

$hasSidebar = page_findnearest($conf['sidebar']);
$showSidebar = $hasSidebar && ($ACT=='show');
?><!DOCTYPE html>
<html lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="utf-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>


    <!--BYU header source -->
        <script async src="https://cdn.byu.edu/byu-theme-components/1.x.x/byu-theme-components.min.js"></script>
        <link rel="stylesheet" href="https://cdn.byu.edu/byu-theme-components/1.x.x/byu-theme-components.min.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--Styling for Sticky BYU Footer-->
            <style>
            html, body {
                height: 100%;
            }

            .containing-element {
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .page-content {
                flex-grow: 1;
                margin-top: 70px;
            }
            </style>

    <!--End BYU header source-->

</head>

<body>
    <div class="containing-element">
        <byu-header full-width>
            
            <h1 slot="site-title" ><?php tpl_link(wl(),$conf['title']) ?></h1> 

            <!--BUTTONS-->
            <?php
                /*if (!empty($_SERVER['REMOTE_USER']) && $INFO['isadmin']) {
                    //Admin tools button
                    echo "<a slot=\"actions\" href=\"http://127.0.0.1/dokuwiki/doku.php?do=admin&id=user%3Aadmin%3Astart\" target=\"_self\">Admin</a>";
                }*/
                if (!empty($_SERVER['REMOTE_USER'])) {
                    //Logout Button
                    echo "<a slot=\"actions\" href=\"javascript:{}\" onclick=\"document.getElementById('log_out').submit(); return false;\">Log Out
                                <form id=\"log_out\" method=\"get\" action=\"/doku.php\">
                                    <input type=\"hidden\" name=\"do\" value=\"logout\">
                                    <input type=\"hidden\" name=\"sectok\" value=\"\">
                                    <input type=\"hidden\" name=\"id\" value=\"start\">
                                </form>
                        </a>";
                    }
                if (empty($_SERVER['REMOTE_USER'])) {
                    //Login Button
                    echo "<a slot=\"actions\" href=\"javascript:{}\" onclick=\"document.getElementById('log_in').submit(); return false;\">Log In
                                <form id=\"log_in\" method=\"get\" action=\"/doku.php\">
                                    <input type=\"hidden\" name=\"do\" value=\"login\">
                                    <input type=\"hidden\" name=\"sectok\" value=\"\">
                                    <input type=\"hidden\" name=\"id\" value=\"start\">
                                </form>
                        </a>";
                }
            ?> 

            <!--font size css seems to be the cause of the disalignment of the search button and search box PLEASE FIX -->
            <byu-search slot="search" action="navigate" action-target="/dokuwiki/doku.php?do=search&id=start&q=${search}" method="get" placeholder="Search"></byu-search>

            <byu-menu slot="nav" collapsed>
                <a href="/doku.php?id=start">Home</a>
                <a href= "/doku.php?id=start&do=index">Sitemap</a>
                <a href="/doku.php?id=start&do=recent">Recent Changes</a>
                <a href="/doku.php?id=start&do=media&ns=">Media Manager</a>
                <?php //Admin tools link
                    if (!empty($_SERVER['REMOTE_USER']) && $INFO['isadmin']) {
                        echo "<a href=\"/doku.php?do=admin&id=user%3Aadmin%3Astart\" target=\"_self\">Admin</a>";
                    }
                ?>
            </byu-menu>
        </byu-header>

        <div class="page-content">
                
            <div id="dokuwiki__site"><div id="dokuwiki__top" class="site <?php echo tpl_classes(); ?> <?php
                echo ($showSidebar) ? 'showSidebar' : ''; ?> <?php echo ($hasSidebar) ? 'hasSidebar' : ''; ?>">

            <!--Trace -->
            <?php tpl_breadcrumbs() ?>

                <div class="wrapper group">

                    <?php if($showSidebar): ?>
                        <!-- ********** ASIDE ********** -->
                        <div id="dokuwiki__aside"><div class="pad aside include group">
                            <h3 class="toggle"><?php echo $lang['sidebar'] ?></h3>
                            <div class="content"><div class="group">
                                <?php tpl_flush() ?>
                                <?php tpl_includeFile('sidebarheader.html') ?>
                                <?php tpl_include_page($conf['sidebar'], true, true) ?>
                                <?php tpl_includeFile('sidebarfooter.html') ?>
                            </div></div>
                        </div></div><!-- /aside -->
                    <?php endif; ?>

                    <!-- ********** CONTENT ********** -->
                    <div id="dokuwiki__content"><div class="pad group">
                        <?php html_msgarea() ?>

                        <div class="pageId"><span><?php echo hsc($ID) ?></span></div>

                        <div class="page group">
                            <?php tpl_flush() ?>
                            <?php tpl_includeFile('pageheader.html') ?>
                            <!-- wikipage start -->
                            <?php tpl_content() ?>
                            <!-- wikipage stop -->
                            <?php tpl_includeFile('pagefooter.html') ?>
                        </div>

                        <div class="docInfo"><?php tpl_pageinfo() ?></div>

                        <?php tpl_flush() ?>
                    </div></div><!-- /content -->

                    <hr class="a11y" />

                    <!-- PAGE ACTIONS -->
                    <div id="dokuwiki__pagetools">
                        <h3 class="a11y"><?php echo $lang['page_tools']; ?></h3>
                        <div class="tools">
                            <ul>
                                <?php echo (new \dokuwiki\Menu\PageMenu())->getListItems(); ?>
                            </ul>
                        </div>
                    </div>
                </div><!-- /wrapper -->

                <?php //include('tpl_footer.php') ?>
            </div></div><!-- /site -->

            <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
            <div id="screen__mode" class="no"></div><?php /* helper to detect CSS media query in script.js */ ?>
        </div>

        <byu-footer></byu-footer>
    </div>
</body>
</html>
