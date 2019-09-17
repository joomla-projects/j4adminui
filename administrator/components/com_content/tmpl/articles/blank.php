<?php
defined('_JEXEC') or die;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('webcomponent', 'system/pagination.es6.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-dropdown.es6.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-breadcrumb.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-modal.es6.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-callout.es6.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-accordion.es6.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-tab.es6.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-alert.es6.min.js', array('version'=> 'auto', 'relative' => true));
?>
<div class="container" style="background:white; padding: 10px;">
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
        <a href="#" id="showCollout" class="btn btn-secondary">Callout Bottom </a>
        <a href="#" id="showCollout2" class="btn btn-secondary">Callout Right </a>
        <a href="#" id="showCollout3" class="btn btn-secondary">Callout Left</a>
        <a href="#" id="showCollout4" class="btn btn-secondary">Callout Top</a>

        <joomla-callout action="hover" for="#showCollout" dismiss="true" position="bottom">
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
            <a href="#" class="btn btn-secondary" id="dropdownList">Dropdown with list</a href="#">
            <joomla-dropdown for="#dropdownList">
                <a class="dropdown-item" href="#">Item 1</a>
                <a class="dropdown-item" href="#">Item 2</a>
                <a class="dropdown-item" href="#">Item 3</a>
            </joomla-dropdown>
        </div>
        <div class="joomla-dropdown-container">
            <a href="#" class="btn btn-secondary" id="dropdownText">Dropdown with text</a href="#">
            <joomla-dropdown for="#dropdownText">
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


        <joomla-modal id="exampleModal2" title="Modal title" close-a href="#"-title="Close" width="100%" height="400px" iframe="https://www.joomla.org">
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
            <div class="j-card">
                <div class="j-card-header">
                    <h4 class="j-card-title">
                        Default Card...
                    </h4>

                    <div class="j-card-header-right">
                        <button class="j-card-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="j-card-body j-card-body-has-padding">
                    <div class="j-card-text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                    </div>
                </div>
                <div class="j-card-footer d-flex align-items-center">
                    <div class="j-card-footer-item">
                        <a href="#">Details Information</a>
                    </div>
                    <div class="j-card-footer-item j-card-footer-icon">
                        <a href="#" class="fas fa-eye"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="j-card">
                <div class="j-card-header j-card-header-sm">
                    <h4 class="j-card-title">
                        Card small header
                    </h4>

                    <div class="j-card-header-right">
                        <button class="j-card-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="j-card-body j-card-body-has-padding">
                    <div class="j-card-text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                    </div>
                </div>
                <div class="j-card-footer">
                    <div class="j-card-footer-item j-card-footer-icon">
                        <button class="fas fa-eye"></button>
                    </div>
                    <div class="j-card-footer-item">
                        <button><i class="fas fa-key"></i> Details Information</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="j-card">
                <div class="j-card-header j-card-header-sm">
                    <p class="j-card-title">
                        <i class="fas fa-pen-alt"></i>
                        Card small title + icon
                    </p>

                    <div class="j-card-header-right">
                        <button class="j-card-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="j-card-body j-card-body-has-padding">
                    <div class="j-card-text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                    </div>
                </div>
                <div class="j-card-footer">
                    <div class="j-card-footer-item">
                        <a href="#">Details Information</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<hr>

    <div class="row justify-content-center" style="padding: 30px 0">
        <div class="col-3">
            <div class="j-card">
                <div class="j-card-header">
                    <h4 class="j-card-title">
                        <i class="fas fa-pen-alt"></i>
                        Card Footer Large
                    </h4>
                    <div class="j-card-header-right">
                        <button class="j-card-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="j-card-body j-card-body-has-padding">
                    <div class="j-card-text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                    </div>
                </div>
                <div class="j-card-footer j-card-footer-lg">
                    <div class="j-card-footer-item">
                        <a href="#">Details Information</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="j-card">
                <div class="j-card-header">
                    <h4 class="j-card-title">
                        <i class="fas fa-pen-alt"></i>
                        Card Footer Large
                    </h4>
                    <div class="j-card-header-right">
                        <button class="j-card-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="j-card-body j-card-body-has-padding">
                    <div class="j-card-text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                    </div>
                </div>
                <div class="j-card-footer j-card-footer-lg">
                    <div class="j-card-footer-item">
                        <a href="#"> <i class="fas fa-key"></i> Details Information</a>
                    </div>
                    <div class="j-card-footer-item j-card-footer-icon">
                        <button class="fas fa-eye"></button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-3">
            <div class="j-card">
                <div class="j-card-header">
                    <h4 class="j-card-title">
                        <i class="fas fa-pen-alt"></i>
                        Card Footer Large
                    </h4>
                    <div class="j-card-header-right">
                        <button class="j-card-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="j-card-body j-card-body-has-padding">
                    <div class="j-card-text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                    </div>
                </div>
                <div class="j-card-footer j-card-footer-lg">
                    <div class="j-card-footer-item">
                        <a href="#"> <i class="j-icon-lg fas fa-cloud-download-alt"></i> Details Information</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<hr>

    <div class="row justify-content-center" style="padding: 30px 0">
        <div class="col-3">
            <div class="j-card">
                <div class="j-card-header">
                    <h4 class="j-card-title">
                        <i class="fas fa-pen-alt"></i>
                        Card Footer Large
                    </h4>
                    <div class="j-card-header-right">
                        <button class="j-card-header-icon fas fa-ellipsis-h"></button>
                    </div>
                </div>
                <div class="j-card-media">
                    <img src="https://picsum.photos/400/300" alt="">
                </div>
                <div class="j-card-body j-card-body-has-padding">
                    <div class="j-card-text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                    </div>
                </div>
                <div class="j-card-footer j-card-footer-lg">
                    <div class="j-card-footer-item">
                        <a href="#"> <i class="j-icon-lg fas fa-cloud-download-alt"></i> Details Information</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-3">
            <div class="j-card">
                <div class="j-card-media">
                    <img src="https://picsum.photos/400/300" alt="">
                </div>
                <div class="j-card-body j-card-body-has-padding">
                    <div class="j-card-text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem earum ex expedita incidunt minus modi odit pariatur provident quasi, vero!
                    </div>
                </div>
                <div class="j-card-footer j-card-footer-lg">
                    <div class="j-card-footer-item">
                        <a href="#"> <i class="j-icon-lg fas fa-cloud-download-alt"></i> Details Information</a>
                    </div>
                </div>
            </div>
        </div>

    </div>


    </section>

</div>
