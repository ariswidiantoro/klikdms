<?php

class __Mustache_2638a31bfe7e992a82ef5d4dfb8d3388 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<!-- #section:settings.box -->
';
        $buffer .= $indent . '<div class="ace-settings-container" id="ace-settings-container">
';
        $buffer .= $indent . '	<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
';
        $buffer .= $indent . '		<i class="ace-icon fa fa-cog bigger-130"></i>
';
        $buffer .= $indent . '	</div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	<div class="ace-settings-box clearfix" id="ace-settings-box">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	  <div class="pull-left width-50">
';
        $buffer .= $indent . '		<!-- #section:settings.skins -->
';
        $buffer .= $indent . '		<div class="ace-settings-item">
';
        $buffer .= $indent . '			<div class="pull-left">
';
        $buffer .= $indent . '				<select id="skin-colorpicker" class="hide">
';
        $buffer .= $indent . '					<option data-skin="no-skin" value="#438EB9">#438EB9</option>
';
        $buffer .= $indent . '					<option data-skin="skin-1" value="#222A2D">#222A2D</option>
';
        $buffer .= $indent . '					<option data-skin="skin-2" value="#C6487E">#C6487E</option>
';
        $buffer .= $indent . '					<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
';
        $buffer .= $indent . '				</select>
';
        $buffer .= $indent . '			</div>
';
        $buffer .= $indent . '			<span>&nbsp; Choose Skin</span>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '		<!-- /section:settings.skins -->
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<!-- #section:settings.navbar -->
';
        $buffer .= $indent . '		<div class="ace-settings-item">
';
        $buffer .= $indent . '			<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
';
        $buffer .= $indent . '			<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '		<!-- /section:settings.navbar -->
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<!-- #section:settings.sidebar -->
';
        $buffer .= $indent . '		<div class="ace-settings-item">
';
        $buffer .= $indent . '			<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
';
        $buffer .= $indent . '			<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '		<!-- /section:settings.sidebar -->
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<!-- #section:settings.breadcrumbs -->
';
        $buffer .= $indent . '		<div class="ace-settings-item">
';
        $buffer .= $indent . '			<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
';
        $buffer .= $indent . '			<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '		<!-- /section:settings.breadcrumbs -->
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<!-- #section:settings.rtl -->
';
        $buffer .= $indent . '		<div class="ace-settings-item">
';
        $buffer .= $indent . '			<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
';
        $buffer .= $indent . '			<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '		<!-- /section:settings.rtl -->
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<!-- #section:settings.container -->
';
        $buffer .= $indent . '		<div class="ace-settings-item">
';
        $buffer .= $indent . '			<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
';
        $buffer .= $indent . '			<label class="lbl" for="ace-settings-add-container"> Inside <b>.container</b> </label>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '		<!-- /section:settings.container -->
';
        $buffer .= $indent . '	  </div><!-- /.pull-left -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	  <div class="pull-left width-50">
';
        $buffer .= $indent . '		<!-- #section:basics/sidebar.options -->
';
        $buffer .= $indent . '		<div class="ace-settings-item">
';
        $buffer .= $indent . '			<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
';
        $buffer .= $indent . '			<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '		<div class="ace-settings-item">
';
        $buffer .= $indent . '			<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
';
        $buffer .= $indent . '			<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '		<div class="ace-settings-item">
';
        $buffer .= $indent . '			<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
';
        $buffer .= $indent . '			<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '		<!-- /section:basics/sidebar.options -->
';
        $buffer .= $indent . '	  </div><!-- /.pull-left -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	</div><!-- /.ace-settings-box -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '</div><!-- /.ace-settings-container -->
';
        $buffer .= $indent . '<!-- /section:settings.box -->
';

        return $buffer;
    }
}
