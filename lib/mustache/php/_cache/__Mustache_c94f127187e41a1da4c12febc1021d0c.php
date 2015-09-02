<?php

class __Mustache_c94f127187e41a1da4c12febc1021d0c extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';
        $newContext = array();

        $buffer .= $indent . '<div class="alert alert-block alert-success">
';
        $buffer .= $indent . '	<button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
';
        $buffer .= $indent . '	<i class="ace-icon fa fa-check green"></i> Welcome to <strong class="green">Ace <small>(v';
        $value = $this->resolveValue($context->findDot('site.version'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= ')</small></strong>,
';
        $buffer .= $indent . '	the lightweight, feature-rich and easy to use admin template.
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="row">
';
        $buffer .= $indent . ' <div class="space-6"></div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . ' <div class="col-sm-7 infobox-container">
';
        $buffer .= $indent . '	<!-- #section:pages/dashboard.infobox -->
';
        // 'page.stats1' section
        $value = $context->findDot('page.stats1');
        $buffer .= $this->section936caf211a929f929c7a0f57f2f7eb31($context, $indent, $value);
        $buffer .= $indent . '	<!-- /section:pages/dashboard.infobox -->
';
        $buffer .= $indent . '	<div class="space-6"></div>
';
        $buffer .= $indent . '	<!-- #section:pages/dashboard.infobox.dark -->
';
        // 'page.stats2' section
        $value = $context->findDot('page.stats2');
        $buffer .= $this->section936caf211a929f929c7a0f57f2f7eb31($context, $indent, $value);
        $buffer .= $indent . '	<!-- /section:pages/dashboard.infobox.dark -->
';
        $buffer .= $indent . ' </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . ' <div class="vspace-12-sm"></div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . ' <div class="col-sm-5">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	<div class="widget-box">
';
        $buffer .= $indent . '		<div class="widget-header widget-header-flat widget-header-small">
';
        $buffer .= $indent . '			<h5 class="widget-title"><i class="ace-icon fa fa-signal"></i> Traffic Sources</h5>
';
        $buffer .= $indent . '			<div class="widget-toolbar no-border">
';
        $buffer .= $indent . '			 <div class="inline dropdown-hover">
';
        $buffer .= $indent . '				<button class="btn btn-minier btn-primary">
';
        $buffer .= $indent . '					This Week <i class="ace-icon fa fa-angle-down icon-on-right bigger-110"></i>
';
        $buffer .= $indent . '				</button>
';
        $buffer .= $indent . '				<ul class="dropdown-menu dropdown-menu-right dropdown-125 dropdown-lighter dropdown-close dropdown-caret">
';
        $buffer .= $indent . '					<li class="active">
';
        $buffer .= $indent . '						<a href="#" class="blue">
';
        $buffer .= $indent . '							<i class="ace-icon fa fa-caret-right bigger-110">&nbsp;</i> This Week
';
        $buffer .= $indent . '						</a>
';
        $buffer .= $indent . '					</li>
';
        $buffer .= $indent . '					<li><a href="#"><i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i> Last Week</a></li>
';
        $buffer .= $indent . '					<li><a href="#"><i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i> This Month</a></li>
';
        $buffer .= $indent . '					<li><a href="#"><i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i> Last Month</a></li>
';
        $buffer .= $indent . '				</ul>
';
        $buffer .= $indent . '			 </div>
';
        $buffer .= $indent . '			</div>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<div class="widget-body">
';
        $buffer .= $indent . '		 <div class="widget-main">
';
        $buffer .= $indent . '			<!-- #section:plugins/charts.flotchart -->
';
        $buffer .= $indent . '			<div id="piechart-placeholder"></div>
';
        $buffer .= $indent . '			<!-- /section:plugins/charts.flotchart -->
';
        $buffer .= $indent . '			
';
        $buffer .= $indent . '			<div class="hr hr8 hr-double"></div>
';
        $buffer .= $indent . '			
';
        $buffer .= $indent . '			<div class="clearfix">
';
        $buffer .= $indent . '				<!-- #section:custom/extra.grid -->
';
        $buffer .= $indent . '				<div class="grid3">
';
        $buffer .= $indent . '					<span class="grey"><i class="ace-icon fa fa-facebook-square fa-2x blue"></i> &nbsp; likes</span>
';
        $buffer .= $indent . '					<h4 class="bigger pull-right">1,255</h4>
';
        $buffer .= $indent . '				</div>
';
        $buffer .= $indent . '				
';
        $buffer .= $indent . '				<div class="grid3">
';
        $buffer .= $indent . '					<span class="grey"><i class="ace-icon fa fa-twitter-square fa-2x purple"></i> &nbsp; tweets</span>
';
        $buffer .= $indent . '					<h4 class="bigger pull-right">941</h4>
';
        $buffer .= $indent . '				</div>
';
        $buffer .= $indent . '				
';
        $buffer .= $indent . '				<div class="grid3">
';
        $buffer .= $indent . '					<span class="grey"><i class="ace-icon fa fa-pinterest-square fa-2x red"></i> &nbsp; pins</span>
';
        $buffer .= $indent . '					<h4 class="bigger pull-right">1,050</h4>
';
        $buffer .= $indent . '				</div>
';
        $buffer .= $indent . '				<!-- /section:custom/extra.grid -->
';
        $buffer .= $indent . '			</div>
';
        $buffer .= $indent . '		 </div><!-- /.widget-main -->
';
        $buffer .= $indent . '		</div><!-- /.widget-body -->
';
        $buffer .= $indent . '	</div><!-- /.widget-box -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . ' </div><!-- /.col -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '</div><!-- /.row -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!-- #section:custom/extra.hr -->
';
        $buffer .= $indent . '<div class="hr hr32 hr-dotted"></div>
';
        $buffer .= $indent . '<!-- /section:custom/extra.hr -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="row">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	<div class="col-sm-5">
';
        $buffer .= $indent . '		<div class="widget-box transparent">
';
        $buffer .= $indent . '			<div class="widget-header widget-header-flat">
';
        $buffer .= $indent . '				<h4 class="widget-title lighter">
';
        $buffer .= $indent . '					<i class="ace-icon fa fa-star orange"></i>
';
        $buffer .= $indent . '					Popular Domains
';
        $buffer .= $indent . '				</h4>
';
        $buffer .= $indent . '				<div class="widget-toolbar">
';
        $buffer .= $indent . '					<a href="#" data-action="collapse">
';
        $buffer .= $indent . '						<i class="ace-icon fa fa-chevron-up"></i>
';
        $buffer .= $indent . '					</a>
';
        $buffer .= $indent . '				</div>
';
        $buffer .= $indent . '			</div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '			<div class="widget-body">
';
        $buffer .= $indent . '			 <div class="widget-main no-padding">
';
        if ($partial = $this->mustache->loadPartial('page.domains')) {
            $buffer .= $partial->renderInternal($context, $indent . '				');
        }
        $buffer .= $indent . '			 </div><!-- /.widget-main -->
';
        $buffer .= $indent . '			</div><!-- /.widget-body -->
';
        $buffer .= $indent . '		</div><!-- /.widget-box -->
';
        $buffer .= $indent . '	</div><!-- /.col -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	<div class="col-sm-7">
';
        $buffer .= $indent . '	  <div class="widget-box transparent">
';
        $buffer .= $indent . '		<div class="widget-header widget-header-flat">
';
        $buffer .= $indent . '			<h4 class="widget-title lighter"><i class="ace-icon fa fa-signal"></i> Sale Stats</h4>
';
        $buffer .= $indent . '			<div class="widget-toolbar">
';
        $buffer .= $indent . '				<a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
';
        $buffer .= $indent . '			</div>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<div class="widget-body">
';
        $buffer .= $indent . '		 <div class="widget-main padding-4">
';
        $buffer .= $indent . '			<div id="sales-charts"></div>
';
        $buffer .= $indent . '		 </div><!-- /.widget-main -->
';
        $buffer .= $indent . '		</div><!-- /.widget-body -->
';
        $buffer .= $indent . '	  </div><!-- /.widget-box -->
';
        $buffer .= $indent . '	</div><!-- /.col -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '</div><!-- /.row -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="hr hr32 hr-dotted"></div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="row">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . ' <div class="col-sm-6">
';
        $buffer .= $indent . '	<div class="widget-box transparent" id="recent-box">
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<div class="widget-header">
';
        $buffer .= $indent . '			<h4 class="widget-title lighter smaller"><i class="ace-icon fa fa-rss orange"></i>RECENT</h4>
';
        $buffer .= $indent . '			<div class="widget-toolbar no-border">
';
        $buffer .= $indent . '				<ul class="nav nav-tabs" id="recent-tab">
';
        $buffer .= $indent . '					<li class="active"><a data-toggle="tab" href="#task-tab">Tasks</a></li>
';
        $buffer .= $indent . '					<li><a data-toggle="tab" href="#member-tab">Members</a></li>
';
        $buffer .= $indent . '					<li><a data-toggle="tab" href="#comment-tab">Comments</a></li>
';
        $buffer .= $indent . '				</ul>
';
        $buffer .= $indent . '			</div>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '		<div class="widget-body">
';
        $buffer .= $indent . '		 <div class="widget-main padding-4">
';
        $buffer .= $indent . '			<div class="tab-content padding-8">
';
        $buffer .= $indent . '				<div id="task-tab" class="tab-pane active">
';
        $buffer .= $indent . '					<h4 class="smaller lighter green">
';
        $buffer .= $indent . '						<i class="ace-icon fa fa-list"></i>
';
        $buffer .= $indent . '						Sortable Lists
';
        $buffer .= $indent . '					</h4>
';
        if ($partial = $this->mustache->loadPartial('page.tasks')) {
            $buffer .= $partial->renderInternal($context, $indent . '					');
        }
        $buffer .= $indent . '				</div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '				<div id="member-tab" class="tab-pane">
';
        if ($partial = $this->mustache->loadPartial('page.members')) {
            $buffer .= $partial->renderInternal($context, $indent . '					');
        }
        $buffer .= $indent . '				</div><!-- /.#member-tab -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '				<div id="comment-tab" class="tab-pane">
';
        if ($partial = $this->mustache->loadPartial('page.comments')) {
            $buffer .= $partial->renderInternal($context, $indent . '					');
        }
        $buffer .= $indent . '				</div>
';
        $buffer .= $indent . '			</div>
';
        $buffer .= $indent . '		 </div><!-- /.widget-main -->
';
        $buffer .= $indent . '		</div><!-- /.widget-body -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '	</div><!-- /.widget-box -->
';
        $buffer .= $indent . ' </div><!-- /.col -->
';
        $buffer .= $indent . ' 
';
        $buffer .= $indent . ' <div class="col-sm-6">
';
        $buffer .= $indent . '	<div class="widget-box ">
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<div class="widget-header">
';
        $buffer .= $indent . '			<h4 class="widget-title lighter smaller">
';
        $buffer .= $indent . '				<i class="ace-icon fa fa-comment blue"></i>
';
        $buffer .= $indent . '				Conversation
';
        $buffer .= $indent . '			</h4>
';
        $buffer .= $indent . '		</div>
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '		<div class="widget-body">
';
        $buffer .= $indent . '		 <div class="widget-main no-padding">
';
        if ($partial = $this->mustache->loadPartial('page.conversations')) {
            $buffer .= $partial->renderInternal($context, $indent . '			');
        }
        $buffer .= $indent . '		 </div><!-- /.widget-main -->
';
        $buffer .= $indent . '		</div><!-- /.widget-body -->
';
        $buffer .= $indent . '		
';
        $buffer .= $indent . '	</div><!-- /.widget-box -->
';
        $buffer .= $indent . ' </div><!-- /.col -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '</div><!-- /.row -->
';
        $buffer .= $indent . '
';

        return $buffer;
    }

    private function section936caf211a929f929c7a0f57f2f7eb31(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
        if (!is_string($value) && is_callable($value)) {
            $source = '
	 {{> page.infobox}}
	';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('page.infobox')) {
                    $buffer .= $partial->renderInternal($context, $indent . '	 ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }
}
