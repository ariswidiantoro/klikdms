<script type="text/javascript" src="<?php echo path_js(); ?>/jquery.min.js"></script>
<script type="text/javascript">
   
    $(document).ready(function() {
          
        function menu(data) {
            //            $.getJSON(data, function(data) {
            //build menu
            var builddata = function() {
                     
                var source = [];
                var items = [];
                for (var i = 0; i < data.length; i++) {
                    //                    var idx = $.inArray(dataid, selectArr);
                    //                    if (idx == -1) {
                    //                        selectArr.push(dataid);
                    //                    } else {
                    //                        selectArr.splice(idx, 1);
                    //                    }
                    var item = data[i];
                    var label = item["menu_nama"];
                    var parentid = item["menu_parent_id"];
                    var id = item["menuid"];
                    var icon = item["menu_icon"];
                    var dekripsi = item["menu_deskripsi"];
                    var url = item["menu_url"];
    
//                    alert(parentid+" LABEL "+label);
                    if (items[parentid]) {
//                        alert("parent id bawah"+label);
                        var item = {parentid: parentid, label: label, url: url, item: item, icon: icon, dekripsi:dekripsi};
                        if (!items[parentid].items) {
                            items[parentid].items = [];
                        }
                        items[parentid].items[items[parentid].items.length] = item;
                        items[id] = item;
                    }
                    else {
                        if (parentid == '<?php echo $menuid; ?>') {
                            items[id] = {parentid: parentid, label: label, url: url, item: item, icon: icon, dekripsi:dekripsi};
                            source[id] = items[id];
                        }
                    }
                }
                return source;
            }
            var buildUL = function(parent, items) {
                $.each(items, function() {
                    if (this.label) {
                        var li = $("<li class=''><a href='#"+this.url+"' data-url='"+this.url+"'><i class='" + this.icon + " '></i><span> " + this.label + "</span></a></li>");
    
                        if (this.items && this.items.length > 0) {
                            li = $("<li class=''><a class='dropdown-toggle' href='#"+this.url+"' data-url='"+this.url+"'><i class='" + this.icon + "'></i>&nbsp;<span>" + this.label + "</span><b class='arrow fa fa-angle-down'></b></a></li>");
                            var ul = $("<ul class='submenu'></ul>");
                            li.appendTo(parent);
                            ul.appendTo(li);
                            buildUL(ul, this.items);
                        } else {
                            li.appendTo(parent);
                        }
                    }
                });
            }
            var source = builddata();
            var ul = $(".nav-list");
            //            ul.appendTo(".nav-list");
            buildUL(ul, source);
            //add bootstrap classes
            if ($(".nav-list>li:has(ul.open)"))
            {
                $(".nav-list>li.submenu").addClass('submenu');
            }
            if ($(".nav-list>li>ul.open>li:has(> ul.open)"))
            {
                $(".nav-list>li>ul.open li ").addClass('submenu');
            }
            $("ul.open").find("li:not(:has(> ul.open))").removeClass("submenu");
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/getMenuSortUrut'); ?>',
            dataType: "json",
            success: function(data) {
                menu(data);
            }
        });
    });

</script>
<ul class="nav nav-list">

</ul><!--/.nav-list-->

