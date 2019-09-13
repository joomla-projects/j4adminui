<?php
defined('_JEXEC') or die;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('webcomponent', 'system/pagination.es6.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-dropdown.es6.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-breadcrumb.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-modal.es6.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-callout.es6.min.js', array('version'=> 'auto', 'relative' => true));
?>

<div class="container">
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
        <a href="#" id="showCollout" class="btn btn-secondary">Callout Bottom </a href="#">
        <a href="#" id="showCollout2" class="btn btn-secondary">Callout Right </a href="#">
        <a href="#" id="showCollout3" class="btn btn-secondary">Callout Left</a href="#">
        <a href="#" id="showCollout4" class="btn btn-secondary">Callout Top</a href="#">

        <joomla-callout for="#showCollout" dismiss="true" position="bottom">
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
</div>
