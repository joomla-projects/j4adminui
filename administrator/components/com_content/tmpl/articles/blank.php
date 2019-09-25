<?php
defined('_JEXEC') or die;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

HTMLHelper::_('webcomponent', 'system/pagination.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-dropdown.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-breadcrumb.js', array('version'=> 'auto', 'relative' => true));
// HTMLHelper::_('webcomponent', 'system/joomla-modal.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-callout.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-accordion.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-tab.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-alert.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-progress.min.js', array('version'=> 'auto', 'relative' => true));
?>
<div class="container" style="background:white; padding: 10px;">
        <h1> Demo Modal </h1>
        <?php 
        
            echo HTMLHelper::_(
                'webcomponent.renderModal',
                'associationSelect',
                array(
                    'title'       => Text::_('COM_ASSOCIATIONS_SELECT_TARGET'),
                    'backdrop'    => 'static',
                    'url'         => 'https://stackoverflow.com/questions/369602/deleting-an-element-from-an-array-in-php',
                    'height'      => '400px',
                    'width'       => '800px',
                    'bodyHeight'  => 70,
                    'modalWidth'  => 80,
                    'footer'      => '<button type="button" class="btn btn-secondary" data-dismiss="modal">'
                            . Text::_("JLIB_HTML_BEHAVIOR_CLOSE") . '</button>',
                )
            );

            echo HTMLHelper::_(
                'webcomponent.renderModal',
                'associationSelect2',
                array(
                    'title'       => Text::_('COM_ASSOCIATIONS_SELECT_TARGET'),
                    'backdrop'    => 'static',
                    'height'      => '400px',
                    'width'       => '800px',
                    'bodyHeight'  => 70,
                    'modalWidth'  => 80,
                    'footer'      => '<button type="button" class="btn btn-secondary" data-dismiss="modal">'
                            . Text::_("JLIB_HTML_BEHAVIOR_CLOSE") . '</button>',
                ),
                '<p> This is awesome paragraph </p>'
            );
        ?>
        <button type="button" data-href="#associationSelect"> Open Modal </button>
        <button type="button" data-href="#associationSelect2"> Open Modal2 </button>
        <h1> Joomla Pgoress </h1>
        <div class="_joomla-progress" style="width: 600px">
            <joomla-progress progress="25"></joomla-progress>
            <joomla-progress stroke="10" radius="100" progress="45" fill="#ff0000"></joomla-progress>
        </div>
        <h1> Joomla Pagination </h1>
        <div class="joomla-pagination" style="width: 600px">
            <joomla-pagination>
                <a class="has-arrow first-page" href="" title="First page"><<</a>
                <a class="has-arrow next-page" href="" title="Next page"><</a>
                <li class="pagination-link" href="#" value="1" text="1"></li>
                <li class="pagination-link" href="#" value="2" text="2"></li>
                <li class="pagination-link" href="#" value="3" text="3"></li>
                <li class="pagination-link" href="#" value="4" text="4"></li>
                <li class="pagination-link" href="#" value="5" text="5"></li>
                <li class="pagination-link" href="#" value="5" text="6"></li>
                <li class="pagination-link" href="#" value="5" text="7"></li>
                <li class="pagination-link" href="#" value="5" text="8"></li>
                <li class="pagination-link" href="#" value="5" text="9"></li>
                <li class="pagination-link" href="#" value="5" text="10"></li>
                <li class="pagination-link" href="#" value="5" text="11"></li>
                <li class="pagination-link" href="#" value="5" text="12"></li>
                <li class="pagination-link" href="#" value="5" text="13"></li>
                <li class="pagination-link" href="#" value="5" text="14"></li>
                <li class="pagination-link" href="#" value="5" text="15"></li>
                <li class="pagination-link" href="#" value="5" text="16"></li>
                <li class="pagination-link" href="#" value="5" text="17"></li>
                <li class="pagination-link" href="#" value="5" text="18"></li>
                <li class="pagination-link" href="#" value="5" text="19"></li>
                <li class="pagination-link" href="#" value="5" text="20"></li>
                <li class="pagination-link" href="#" value="5" text="21"></li>
                <li class="pagination-link" href="#" value="5" text="22"></li>
                <li class="pagination-link" href="#" value="5" text="23"></li>
                <li class="pagination-link" href="#" value="5" text="24"></li>
                <li class="pagination-link" href="#" value="5" text="25"></li>
                <li class="pagination-link" activeClass="active" href="#" value="5" text="26"></li>
                <li class="pagination-link" href="#" value="5" text="27"></li>
                <li class="pagination-link" href="#" value="5" text="28"></li>
                <li class="pagination-link" href="#" value="5" text="29"></li>
                <li class="pagination-link" href="#" value="5" text="30"></li>
                <li class="pagination-link" href="#" value="5" text="31"></li>
                <a class="has-arrow prev-page" href="" title="Prev page">></a>
                <a class="has-arrow last-page" href="" title="Last page">>></a>
            </joomla-pagination>
        </div>
    <br><hr>
    <div style="width: 600px">
        <h1> Joomla Breadcrumb </h1>
        <joomla-breadcrumb aria-label="breadcrumb">
            <li href="#" text="page 1" class="class-a class-b"></li>
            <li href="#" text="page 2"></li>
            <li href="#" text="page 3"></li>
            <li href="#" text="page 4"></li>
            <li href="#" text="page 5"></li>
            <li href="#" text="page 6"></li>
            <li href="#" text="page 7"></li>
            <li href="#" text="page 8"></li>
            <li href="#" text="page 9"></li>
            <li href="#" text="page 10"></li>
            <li href="#" text="page 11"></li>
            <li href="#" text="page 12"></li>
            <li href="#" text="page 13"></li>
            <li href="#" text="page 14"></li>
            <li href="#" text="page 15"></li>
            <li href="#" text="page 16"></li>
            <li href="#" text="page 17"></li>
            <li href="#" text="page 18" activeClass="active"></li>
        </joomla-breadcrumb>
    </div>
    <br><hr>
    <h1> Joomla Callout </h1>
    <div style="width: 100%">
        <a href="#" id="showCollout1" class="btn btn-secondary">Callout Bottom </a>
        <a href="#" id="showCollout2" class="btn btn-secondary">Callout Right </a>
        <a href="#" id="showCollout3" class="btn btn-secondary">Callout Left</a>
        <a href="#" id="showCollout4" class="btn btn-secondary">Callout Top</a>

        <joomla-callout action="hover" for="#showCollout1" dismiss="true" position="bottom">
            <div class="callout-title">Title</div>
            <div class="callout-content">
                Message body is optional.  If help documentation is available, consider adding a link to learn more
            </div>
            <a href="#" class="callout-link" target="blank">Learn more</a>
        </joomla-callout>

        <joomla-callout for="#showCollout2" dismiss="true" position="right">
            <div class="callout-title">Title</div>
            <div class="callout-content">
                Message body is optional.  If help documentation is available, consider adding a link to learn more
            </div>
            <div class="callout-footer">
                <a href="#" class="callout-link" target="blank">Learn more</a>
            </div>
        </joomla-callout>
        <joomla-callout for="#showCollout3" dismiss="true" position="left">
            <div class="callout-title">Callout Left</div>
            <div class="callout-content">
                Message body is optional.  If help documentation is available, consider adding a link to learn more
            </div>
            <div class="callout-footer">
                <a href="#" class="callout-link" target="blank">Learn more</a>
            </div>
        </joomla-callout>
        <joomla-callout for="#showCollout4" dismiss="true" position="top">
            <div class="callout-title">Callout Top</div>
            <div class="callout-content">
                Message body is optional.  If help documentation is available, consider adding a link to learn more
            </div>
            <div class="callout-footer">
                <a href="#" class="callout-link" target="blank">Learn more</a>
            </div>
        </joomla-callout>
    </div>
    <br><hr>
    <h1> Joomla Dropdown </h1>
    <div style="width: 100%">
        <div class="joomla-dropdown-container">
            <a href="#" class="btn btn-secondary" data-target="dropdownList1">Dropdown with list</a>
            <joomla-dropdown for="dropdownList1">
                <li class="has-submenu" data-action="hover">
                    <a class="dropdown-item" >Item 1</a>
                    <ul class='submenu'>
                        <li><a class="dropdown-item" href="#" title="Sub Menu">Sub Menu 1</a></li>
                        <li><a class="dropdown-item" href="#" title="Sub Menu">Sub Menu 2</a></li>
                        <li><a class="dropdown-item" href="#" title="Sub Menu">Sub Menu 3</a></li>
                        <li><a class="dropdown-item" href="#" title="Sub Menu">Sub Menu 4</a></li>
                    </ul>
                </li>
                <li class="has-submenu" data-action="hover">
                    <a class="dropdown-item" >Item 2</a>
                    <ul class='submenu'>
                        <li><a class="dropdown-item" href="#" title="Sub Menu">Sub Menu 1</a></li>
                        <li><a class="dropdown-item" href="#" title="Sub Menu">Sub Menu 2</a></li>
                        <li><a class="dropdown-item" href="#" title="Sub Menu">Sub Menu 3</a></li>
                        <li><a class="dropdown-item" href="#" title="Sub Menu">Sub Menu 4</a></li>
                    </ul>
                </li>
                <li><a class="dropdown-item" href="#">Item 3</a></li>
            </joomla-dropdown>
        </div>
        <div class="joomla-dropdown-container">
            <a href="#" class="btn btn-secondary" data-target="dropdownList2">Dropdown with list</a>
            <joomla-dropdown for="dropdownList2" position="left">
                <li class="has-submenu">
                    <a class="dropdown-item" >Item 1</a>
                    <ul class='submenu'>
                        <li><a class="dropdown-item" href="#" title="Sub Menu">Sub Menu 1</a></li>
                        <li><a class="dropdown-item" href="#" title="Sub Menu">Sub Menu 2</a></li>
                        <li><a class="dropdown-item" href="#" title="Sub Menu">Sub Menu 3</a></li>
                        <li><a class="dropdown-item" href="#" title="Sub Menu">Sub Menu 4</a></li>
                    </ul>
                </li>
                <li><a class="dropdown-item" href="#">Item 2</a></li>
                <li><a class="dropdown-item" href="#">Item 3</a></li>
            </joomla-dropdown>
        </div>
        <div class="joomla-dropdown-container">
            <a href="#" class="btn btn-secondary" data-target="dropdownText">Dropdown with text</a>
            <joomla-dropdown for="dropdownText">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </joomla-dropdown>
        </div>
    </div>
    <br><hr>
    <h1> Joomla Accordion </h1>
    <div style="width: 600px">
        <joomla-accordion toggle="true" animation="true">
            <section class="accordion-item" id="accordion-panel1" name="Accordion panel 1">
                <h3>Tab panel 1</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                    irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            </section>
            <section class="accordion-item show"  id="accordion-panel2" name="Accordion panel 2">
                <h3>Tab panel 2</h3>
                <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Duis aute
                    irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                    cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </section>
            <section class="accordion-item" id="accordion-panel3" name="Accordion panel 3">
                <h3>Tab panel 3</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                    irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            </section>
        </joomla-accordion>
    </div>
    <br><hr>
    <h1> Joomla Tab </h1>
    <div style="width: 600px">
        <joomla-tab>
            <section orientation="vertical" id="tab-panel1" name="Tab panel 1">
                    <h3>Tab panel 1</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            </section>
            <section id="tab-panel2" name="Tab panel 2">
                    <h3>Tab panel 2</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            </section>
            <section id="tab-panel3" name="Tab panel 3" disabled="true">
                    <h3>Tab panel 1</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            </section>
        </joomla-tab>
    </div>
    <br><hr>
    <h1> Joomla Modal </h1>
    <div style="width: 100%">
        <a href="#" class="btn btn-primary" data-href="#exampleModal1">Launch demo modal</a href="#">
        <a href="#" class="btn btn-primary" data-href="#exampleModal2">Modal with iframe</a href="#">
        <joomla-modal id="exampleModal1" class="bordered" title="Modal title" close-a href="#"-title="Close">
            <section>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard
                dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen
                book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially
                unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more
                recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
            </section>
            <footer>
                <div class="modal-footer-left-text">hint text</div>
                <a href="#" class="btn btn-secondary" data-dismiss>Close</a href="#">
                <a href="#" class="btn btn-primary">Save changes</a href="#">
            </footer>
        </joomla-modal>


        <joomla-modal id="exampleModal2" title="Modal title" close-a href="#"-title="Close" width="100%" height="400px" iframe="http://10.0.1.71/wp_sites/wpmm/">
            <section>
                <h4>I'm a Modal</h4>
            </section>
            <footer>
                <a href="#" class="btn btn-secondary" data-dismiss>Close</a href="#">
                <a href="#" class="btn btn-primary">Save changes</a href="#">
            </footer>
        </joomla-modal>
    </div>
    <br><hr>
    <h1> Joomla Alert </h1>
    <div style="width:100%">
            <!-- Alert with icon & content -->
        <joomla-alert dismiss="true">
            <div class="joomla-alert--icon">
                <img src="./smile.svg" alt="">
            </div>
            <div class="joomla-alert-content">
                Alert with icon & content
                <div class="joomla-alert-link-group">
                    <a href="#">Link1</a>
                    <a href="#">Link2</a>
                </div>
            </div>
        </joomla-alert>

            <!-- Alert with header & content -->
        <joomla-alert dismiss="true">
            <div class="joomla-alert--icon">
                <img src="./smile.svg" alt="">
            </div>
            <div class="joomla-alert-content">
                Alert with icon & content
                <div class="joomla-alert-link-group">
                    <a href="#">Link1</a>
                    <a href="#">Link2</a>
                </div>
            </div>
        </joomla-alert>

        <!-- collapse & collapse title -->
        <joomla-alert collapse-title="Collapsible allert with icon" collapse="true">
            <div class="joomla-alert--icon">
                <img src="./smile.svg" alt="">
            </div>
            <div class="joomla-alert--collapse">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptates odit consequatur illum?
                    <div class="joomla-alert-button-group">
                        <button>Sure!</button>
                        <button>Noooo!</button>
                    </div>
            </div>
        </joomla-alert>

        <!-- Alert type: success, danger, warning. Alert dismiss: true -->
        <joomla-alert type="success" dismiss="true">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptates odit consequatur illum?
        </joomla-alert>
        <joomla-alert type="warning" dismiss="true">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptates odit consequatur illum?
        </joomla-alert>
        <joomla-alert type="danger" dismiss="true" auto-dismiss="2000">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptates odit consequatur illum?
        </joomla-alert>
    </div>


    <section style="background: lightgray; padding: 30px 0">
    <h1> Joomla Card </h1>

    <div class="row justify-content-center">
        <div class="col-3">
            <div class="jcard jcard-has-hover">
                <div class="jcard-header">
                    <h4 class="jcard-title">
                        Default Card...
                    </h4>

                    <div class="jcard-header-right">
                        <button class="jcard-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="jcard-body p-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                </div>
                <div class="jcard-footer d-flex align-items-center">
                    <div class="jcard-footer-item">
                        <a href="#">Details Information</a>
                    </div>
                    <div class="jcard-footer-item jcard-footer-icon">
                        <a href="#" class="fas fa-eye"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="jcard jcard-has-hover">
                <div class="jcard-header jcard-header-sm">
                    <h4 class="jcard-title">
                        Card small header
                    </h4>

                    <div class="jcard-header-right">
                        <button class="jcard-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="jcard-body p-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                </div>
                <div class="jcard-footer">
                    <div class="jcard-footer-item jcard-footer-icon">
                        <button class="fas fa-eye"></button>
                    </div>
                    <div class="jcard-footer-item">
                        <button><span class="jcard-icon fas fa-key"></span> Details Information</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="jcard jcard-has-hover">
                <div class="jcard-header jcard-header-sm">
                    <p class="jcard-title">
                        <i class="jcard-icon fas fa-pen-alt"></i>
                        Card small title + icon
                    </p>

                    <div class="jcard-header-right">
                        <button class="jcard-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="jcard-body p-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                </div>
                <div class="jcard-footer">
                    <div class="jcard-footer-item">
                        <a href="#">Details Information</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<hr>

    <div class="row justify-content-center" style="padding: 30px 0">
        <div class="col-3">
            <div class="jcard jcard-has-hover">
                <div class="jcard-header">
                    <h4 class="jcard-title">
                        <span class="jcard-icon fas fa-pen-alt"></span>
                        Card Footer Large
                    </h4>
                    <div class="jcard-header-right">
                        <button class="jcard-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="jcard-body p-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                </div>
                <div class="jcard-footer jcard-footer-lg">
                    <div class="jcard-footer-item">
                        <a href="#">Details Information</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="jcard jcard-has-hover">
                <div class="jcard-header">
                    <h4 class="jcard-title">
                        <span class="jcard-icon fas fa-pen-alt"></span>
                        Card Footer Large
                    </h4>
                    <div class="jcard-header-right">
                        <button class="jcard-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="jcard-body p-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                </div>
                <div class="jcard-footer jcard-footer-lg">
                    <div class="jcard-footer-item">
                        <a href="#"> <span class="jcard-icon fas fa-key"></span> Details Information</a>
                    </div>
                    <div class="jcard-footer-item jcard-footer-icon">
                        <button class="fas fa-eye"></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="jcard jcard-has-hover">
                <div class="jcard-header">
                    <h4 class="jcard-title">
                        <span class="jcard-icon fas fa-pen-alt"></span>
                        Card Footer Large
                    </h4>
                    <div class="jcard-header-right">
                        <button class="jcard-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="jcard-body p-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                </div>
                <div class="jcard-footer jcard-footer-lg">
                    <div class="jcard-footer-item">
                        <a href="#"> <span class="jcard-icon j-icon-lg fas fa-cloud-download-alt"></span> Details Information</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<hr>

    <div class="row justify-content-center" style="padding: 30px 0">
        <div class="col-3">
            <div class="jcard jcard-has-hover">
                <div class="jcard-header">
                    <h4 class="jcard-title">
                        <span class="jcard-icon fas fa-pen-alt"></span>
                        Card Footer Large
                    </h4>
                    <div class="jcard-header-right">
                        <button class="jcard-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="jcard-media">
                    <img src="https://picsum.photos/400/300" alt="">
                </div>
                <div class="jcard-body p-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                </div>
                <div class="jcard-footer jcard-footer-lg">
                    <div class="jcard-footer-item">
                        <a href="#"> <span class="jcard-icon j-icon-lg fas fa-cloud-download-alt"></span> Details Information</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-3">
            <div class="jcard">
                <div class="jcard-media">
                    <img src="https://picsum.photos/id/684/400/300" alt="">
                </div>
                <div class="jcard-body p-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                </div>
                <div class="jcard-footer jcard-footer-lg">
                    <div class="jcard-footer-item">
                        <a href="#"> <span class="jcard-icon j-icon-lg fas fa-cloud-download-alt"></span> Details Information</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-4">
            <div class="jcard jcard-has-hover">
                <div class="jcard-media">
                    <img src="https://picsum.photos/id/684/400/300" alt="">
                    <div class="jcard-media-overlay align-items-center justify-content-center">
                        <button class="btn btn-success">Hello</button>
                    </div>
                </div>
                <div class="jcard-body p-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                </div>
                <span class="jcard-divider mx-3"></span>
                <div class="jcard-btn-group p-3">
                    <a class="btn btn-primary" href="#">Button 1 Button 1</a>
                    <button class="btn"> <i class="icon fas fa-cog"></i> Button 2</button>
                </div>
                <div class="jcard-footer jcard-footer-lg">
                    <div class="jcard-footer-item">
                        <a href="#"> <span class="jcard-icon j-icon-lg fas fa-cloud-download-alt"></span> Details Information</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

        <div class="row justify-content-center">
            <div class="col-4">
                <div class="jcard jcard-has-hover">
                    <div class="jcard-media">
                        <img src="https://picsum.photos/id/684/400/300" alt="">
                    </div>
                    <div class="jcard-body p-3">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                    </div>
                    <span class="jcard-divider mx-3"></span>

                    <div class="jcard-item-group p-4">
                        <div class="jcard-item">
                            <span>Hello</span>
                        </div>
                        <div class="jcard-item">
                            <span class="fab fa-facebook"></span>
                        </div>
                        <div class="jcard-item jcard-item-right">
                            content right
                        </div>
                        <div class="jcard-item">
                            content right
                        </div>
                    </div>

                    <span class="jcard-divider mx-3"></span>

                    <div class="jcard-btn-group p-3">
                        <a class="btn btn-primary" href="#">Button 1 Button 1</a>
                        <button class="btn"> <span class="icon fas fa-cog"></span> Button 2</button>
                    </div>
                    <div class="jcard-footer jcard-footer-lg">
                        <div class="jcard-footer-item">
                            <a href="#"> <span class="jcard-icon j-icon-lg fas fa-cloud-download-alt"></span> Details Information</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="jcard jcard-has-hover">
                    <div class="jcard-header jcard-header-sm">
                        <div class="jcard-header-right">
                            <button class="jcard-header-icon fas fa-ellipsis-h"></button>
                        </div>
                    </div>
                    <div class="jcard-overview-box">
                        <div class="jcard-overview-icon j-warning">
                            <span class="fab fa-invision"></span>
                        </div>
                        <div class="jcard-overview-content">
                            65 <sub>Article</sub>
                        </div>
                    </div>
                    <div class="jcard-footer jcard-footer-lg">
                        <div class="jcard-footer-item">
                            <a href="#"> <span class="jcard-icon j-icon-lg fas fa-cloud-download-alt"></span> Details Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="jcard jcard-has-hover">
                    <div class="jcard-header">
                        <h4 class="jcard-header-title">Table</h4>
                        <div class="jcard-header-right">
                            <button class="jcard-header-icon fas fa-ellipsis-h"></button>
                        </div>
                    </div>

                    <table>
                        <tbody>
                            <tr>
                                <th>Time</th>
                                <td>20:45</td>
                            </tr>
                            <tr>
                                <th>SQL</th>
                                <td>MySQLi 5.6.35</td>
                            </tr>
                            <tr>
                                <th>OS</th>
                                <td>Darwin 7.1</td>
                            </tr>
                            <tr>
                                <th>Time</th>
                                <td>20:45</td>
                            </tr>
                            <tr>
                                <th>SQL</th>
                                <td>MySQLi 5.6.35</td>
                            </tr>
                            <tr>
                                <th>OS</th>
                                <td>Darwin 7.1</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="jcard-event-list">
                        <div class="jcard-event-item">
                            <time datetime="2019-07-13"> <!-- yyyy-mm-dd -->
                                <span>13</span>
                                July 2019
                            </time>
                            <div class="jcard-event-content">
                                <span>Project Release News</span>
                                <h5>Project Release News</h5>
                            </div>
                        </div>
                        <div class="jcard-event-item">
                            <time datetime="2019-07-13"> <!-- yyyy-mm-dd -->
                                <span>13</span>
                                July 2019
                            </time>
                            <div class="jcard-event-content">
                                <span>Project Release News</span>
                                <h5>Because Open Source Matters and Domains too! </h5>
                            </div>
                        </div>
                        <div class="jcard-event-item">
                            <time datetime="2019-07-13"> <!-- yyyy-mm-dd -->
                                <span>13</span>
                                July 2019
                            </time>
                            <div class="jcard-event-content">
                                <span>Project Release News</span>
                                <h5>Because Open Source Matters and Domains too! </h5>
                            </div>
                        </div>
                    </div>

                    <div class="jcard-footer jcard-footer-lg">
                        <div class="jcard-footer-item">
                            <a href="#"> <span class="jcard-icon j-icon-lg fas fa-cloud-download-alt"></span> Details Information</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <hr>

        <div class="row justify-content-center">
            <div class="col-5">
                <div class="jcard jcard-quick-link j-success jcard-has-hover">
                    <div class="jcard-header jcard-header-sm">
                        <div class="jcard-header-right">
                            <button class="jcard-header-icon fas fa-ellipsis-h"></button>
                        </div>
                    </div>
                    <div class="jcard-quick-link-body">
                        <span class="fas fa-image jcard-icon"></span>
                        <div class="jcard-quick-link-content">
                            <a href="#">Learn Joomla</a>
                            <p>Learn Joomla FREE</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="jcard jcard-has-hover">
                    <div class="jcard-header">
                        <h4>Recent activities</h4>
                        <div class="jcard-header-right">
                            <button class="jcard-header-icon fas fa-ellipsis-h"></button>
                        </div>
                    </div>

                    <div class="jcard-activity-list">
                        <div class="jcard-activity-item">
                            <div class="jcard-activity-avatar">
                                <span class="fas fa-user"></span>
                            </div>
                            <div class="jcard-activity-content">
                                <time datetime="2008-02-14 20:00">31.08.2017 <span class="j-separator">|</span> 6:04</time>
                                <h4>Obi-Wan Kenobi <span>(Admin)</span></h4>
                                <h5 class="jcard-activity-type">Wrote Article: Service</h5>
                                <p>You can select from a number of options for customising the look of your templates. The Template Manager supports…</p>
                            </div>
                        </div>
                        <div class="jcard-activity-item">
                            <div class="jcard-activity-avatar">
                                <span class="fas fa-user"></span>
                            </div>
                            <div class="jcard-activity-content">
                                <time datetime="2008-02-14 20:00">31.08.2017 <span class="j-separator">|</span> 6:04</time>
                                <h4>Obi-Wan Kenobi <span>(Admin)</span></h4>
                                <h5 class="jcard-activity-type">Wrote Article: Service</h5>
                                <p>You can select from a number of options for customising the look of your templates. The Template Manager supports…</p>
                            </div>
                        </div>
                        <div class="jcard-activity-item">
                            <div class="jcard-activity-avatar">
                                <span class="fas fa-user"></span>
                            </div>
                            <div class="jcard-activity-content">
                                <time datetime="2008-02-14 20:00">31.08.2017 <span class="j-separator">|</span> 6:04</time>
                                <h4>Obi-Wan Kenobi <span>(Admin)</span></h4>
                                <h5 class="jcard-activity-type">Wrote Article: Service</h5>
                                <p>You can select from a number of options for customising the look of your templates. The Template Manager supports…</p>

                                <p>
                                    <span class="switcher-wrap">
                                        <span class="switcher-alt"></span>
                                        <span>No</span>
                                    </span>

                                <br> You can select from a number of options for customising the look
                                <span class="switcher-wrap">
                                    <span>Yes</span>
                                    <span class="switcher-alt checked"></span>
                                </span>  of your templates. The Template Manager supports…
                                </p>

                                <h2>
                                    <span class="switcher-wrap"> <span class="switcher-alt"></span> <a href="#">No.</a></span> My name is
                                </h2>

                                <br>
                                <!-- single radio -->
                                <input class="jradio" type="radio" name="name">

                                <br>

                                <!-- Radio + label -->
                                <label class="jradio-label">
                                    <input type="radio" name="radio1" id="radio1"> Label + Radio
                                </label>
                                <br>

                                <br>

                                <!-- radio group -->
                                <div class="jradio-group">
                                    <label>
                                        <input type="radio" name="radio1" id="radio1"> Group + Label + Radio
                                    </label>
                                    <label>
                                        <input type="radio" name="radio1" id="radio2"> Group + Label + Radio
                                    </label>
                                </div>

                                <br>

                                <!-- single checkbox -->
                                <input class="jcheckbox" type="checkbox" name="name">

                                <br>

                                <!-- check box + label -->
                                <label class="jcheckbox-label">
                                    <input type="checkbox" name="check1" id="check2"> Label + Checkbox
                                </label>
                                <br>

                                <br>

                                <!-- checkbox group -->
                                <div class="jcheckbox-group">
                                    <label>
                                        <input type="checkbox" name="checkbox1" id="checkbox1"> Group + Label + checkbox
                                    </label>
                                    <label>
                                        <input type="checkbox" name="checkbox2" id="checkbox2"> Group + Label + checkbox
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </section>

</div>
