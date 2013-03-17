var _prefix = 'http://localhost/shuijing/index.php';
var cateWin = $("#cate-window").window({closed:true});
var proWin  = $("#pro-window").window({closed:true});
var cateForm = cateWin.find("form");
var proForm = proWin.find("form");
var index = function() {
    var that = this;
    $("#cate-tree").tree({
        url: _prefix + '/index/gettree',
        onLoadSuccess : function(node, data) {
            $("#cate-tree").tree('collapseAll');
            $("#cate-tree").tree('select', $("#cate-tree").tree('find', 1).target);
            $("#cate-tree").tree('expand', $("#cate-tree").tree('find', 1).target);
            that.loadPro('/index/getList/'+ $("#cate-tree").tree('find', 1).id);
        },
        onSelect : function (node) {
            that.loadPro('/index/getList/'+ node.id);
        }
    });
    this.listen();
}
index.prototype.constructor = index;
index.prototype.loadPro = function(url) {
    $('#shuijing-table').datagrid({
        title: '商品列表',
        nowrap: false,
        animate: true,
        collapsible: true,
        url: _prefix + url,
        idField: 'id',
        singleSelect: true,
        width:1000,
        height:500,
        resizable:true,
        loadMsg: "数据加载中，请稍后...",
//        frozenColumns: [[
//            {field:"ck",checkbox:true },
//
//        ]],
        columns: [[
            { field: "name", title: "商品名称", width: 150},
            { field: "catename", title: "类别名", width: 150},
            { field: "aprice", title: "商城价格", width: 150},
            { field: "bprice", title: "分销价格", width: 150},
            { field: "image", title: "商品图片", width: 150,align:"center",formatter:function(value,rec){
                return '<img src="'+ value + '" width=50 height=50/>';
            }
            },
            { field: "ctime", title: "创建时间", width: 180 }
        ]],
        pagination:true,
        onClickRow: function (row) {
            //$("#tree").treegrid("unselect", row.id);
        },
        onDblClickRow : this.editProduct,
        toolbar:[{
            text:'新增',
            iconCls:'icon-add',
            handler:this.addProduct
        },'-',{
            text:'修改',
            iconCls:'icon-edit',
            handler:this.editProduct
        },'-',{
            text:'删除',
            iconCls:'icon-remove',
            handler:this.delProduct
        }]
    });
}
index.prototype.listen = function() {
    $("#addCate").click(function(){
        cateWin.window('open');
        cateForm.form('clear');
        var _row = $("#cate-tree").tree('getSelected');
        if (_row) {
            cateForm.form('load',{fid:_row.id});
        }
        cateForm.url = _prefix + '/index/saveCate';
    });
    $("#editCate").click(function(){
        var _row = $("#cate-tree").tree('getSelected');
        if (_row) {
            cateForm.url = _prefix + '/index/saveCate/'+_row.id;
            cateForm.form('load',{name:_row.text});
            cateWin.window('open');
        } else {
            $.messager.show({title:'警告',msg:'请先选择要修改的分类！',style:{top:document.body.scrollTop+document.documentElement.scrollTop}});
        }
    });
    $("#delCate").click(function(){
        var _row = $("#cate-tree").tree('getSelected');
        if (_row) {
            $.messager.confirm('确认','确认要删除吗亲?',function(r){
                if (r){
                    $.ajax({
                        url :  _prefix + '/index/delCate/'+_row.id,
                        dataType : "json",
                        method : "post",
                        success: function(data) {
                            if (data.errorcode==1) {
                                $.messager.alert('错误',data.message,'error');
                            } else {
                                $("#cate-tree").tree('reload');
                                $.messager.alert('成功',data.message,'success');
                            }
                        }
                    });
                }
            });
        } else {
            $.messager.show({title:'警告',msg:'请先选择要删除的分类！',style:{top:document.body.scrollTop+document.documentElement.scrollTop}});
        }
    });
    $("#cateWin-cancel").click(function(){
        cateWin.window('close');
    })
    $("#cateWin-save").click(this.saveCate);
    $("#proWin-cancel").click(function(){
        proWin.window('close');
    })
    $("#proWin-save").click(this.savePro);
    this.upload();
}
index.prototype.upload = function () {
    var that=this;
    $("#image").one("change", function(){
        $.ajaxFileUpload({
            url: _prefix + '/index/saveImage',
            fileElementId:'image',
            type : "post",
            dataType: 'json',
            success: function (data, status) {
                $("#relimage").val(data.message);
                that.upload();
            }
        });
        return false;
    });
}
index.prototype.addProduct = function() {
    proWin.window('open');
    var _row = $("#cate-tree").tree('getSelected');
    if (_row) {
        proForm.form('load',{cateid:_row.id,catename:_row.text,name:'',image:'',aprice:'',bprice:'',relimage:''});
        proForm.url = _prefix + '/index/savePro';
    } else {
        $.messager.show({title:'警告',msg:'请先选择分类！',style:{top:document.body.scrollTop+document.documentElement.scrollTop}});
    }

}
index.prototype.editProduct = function() {
    var _row = $('#shuijing-table').datagrid('getSelected');
    if (!_row) {
        $.messager.show({title:'警告',msg:'请先选择条目！',style:{top:document.body.scrollTop+document.documentElement.scrollTop}});
        return false;
    }
    proWin.window('open');
    proForm.url = _prefix + '/index/savePro/'+_row.id;
    proForm.form('load',{cateid:_row.cateid,catename:_row.catename,name:_row.name,image:'',aprice:_row.aprice,bprice:_row.bprice,relimage:''});
}
index.prototype.saveCate = function() {
    cateForm.form('submit', {
        url:cateForm.url,
        success:function(data){
            eval('data='+data);
            if (data.errorcode==1) {
                $.messager.alert('错误',data.message,'error');
            } else {
                $.messager.progress();
                $("#cate-tree").tree('reload');
                $.messager.progress('close');
                cateWin.window('close');
                //$.messager.alert('成功',data.message,'success');
            }
        }
    });
}
index.prototype.savePro = function() {
    proForm.form('submit', {
        url : proForm.url,
        success : function(data) {
            eval('data='+data);
            if (data.errorcode==1) {
                $.messager.alert('错误',data.message,'error');
            } else {
                $('#shuijing-table').datagrid('reload');
                proWin.window('close');
            }
        }
    })
}
index.prototype.delProduct = function() {
    var _row = $('#shuijing-table').datagrid('getSelected');
    if (!_row) {
        $.messager.show({title:'警告',msg:'请先选择条目！',style:{top:document.body.scrollTop+document.documentElement.scrollTop}});
        return false;
    }
    $.messager.confirm('确认','确认要删除吗亲?',function(r){
        if (r){
            $.ajax({
                url :  _prefix + '/index/delPro/'+_row.id,
                dataType : "json",
                method : "post",
                success: function(data) {
                    if (data.errorcode==1) {
                        $.messager.alert('错误',data.message,'error');
                    } else {
                        $('#shuijing-table').datagrid('reload');
                        //$.messager.alert('成功',data.message,'success');
                    }
                }
            });
        }
    });

}
new index();