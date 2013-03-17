<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>水晶100后台</title>
    <link rel="stylesheet" type="text/css" href="./themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="./themes/icon.css">
    <script type="text/javascript" src="./js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="./js/jquery.easyui.min.js"></script>
</head>
<body  class="easyui-layout">
<div data-options="region:'north',border:false" style="height:60px;padding-left:10px"><h1>水晶100商品后台</h1></div>
<div data-options="region:'west',split:true,title:'菜单栏'" style="width:280px;">
    <div style="border:1px solid #ddd">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" id="addCate">新增</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" id="editCate">修改</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cut" plain="true" id="delCate">删除</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-back" plain="true" id="logOut">退出</a>
    </div>
    <ul id="cate-tree"></ul>
</div>
<div data-options="region:'center',title:''">
    <table id="shuijing-table">
        <thead>
        <tr>
            <th field="id" width="100">商品ID</th>
            <th field="name" width="100">商品名称</th>
            <th field="aprice" width="100">商品价格</th>
            <th field="bprice" width="100">代理价格</th>
        </tr>
        </thead>
    </table>
</div>
<div id="cate-window" title="类别" style="width:400px;height:150px;">
    <div style="padding:20px 20px 20px 80px;">
        <form method="post">
            <table>
                <tr>
                    <td>名称：</td>
                    <td><input class="easyui-validatebox" type="text" name="name" data-options="required:true"></input></td>
                    <input  type="hidden" name="fid" value="0"></input>
                </tr>
            </table>
        </form>
    </div>
    <div style="text-align:center;padding:5px;">
        <a href="javascript:void(0)"  class="easyui-linkbutton" id="cateWin-save" icon="icon-save">保存</a>
        <a href="javascript:void(0)"  class="easyui-linkbutton" id="cateWin-cancel" icon="icon-cancel">取消</a>
    </div>
</div>
<div id="pro-window" title="商品" style="width:450px;height:280px;">
    <div style="padding:20px 20px 20px 80px;">
        <form method="post" >
            <table>
                <tr>
                    <td>名称：</td>
                    <td><input class="easyui-validatebox" type="text" name="name" data-options="required:true"></input></td>
                </tr>
                <tr>
                    <td>类别：</td>
                    <td><input class="easyui-validatebox" type="text" name="catename" readonly="readonly" ></input></td>
                    <input  type="hidden" name="cateid" value="0"></input>
                </tr>
                    <td>市场价格：</td>
                    <td><input class="easyui-validatebox" type="text" name="aprice" data-options="required:true"></input></td>
                </tr>
                </tr>
                    <td>分销价格：</td>
                    <td><input class="easyui-validatebox" type="text" name="bprice" ></input></td>
                </tr>
                <tr>
                    <td>图片：</td>
                    <td><input  type="file" name="image" id="image" ></input></td>
                </tr><input  type="hidden" name="relimage"  id="relimage" >
            </table>
        </form>
    </div>
    <div style="text-align:center;padding:5px;">
        <a href="javascript:void(0)"  class="easyui-linkbutton" id="proWin-save" icon="icon-save">保存</a>
        <a href="javascript:void(0)"  class="easyui-linkbutton" id="proWin-cancel" icon="icon-cancel">取消</a>
    </div>
</div>
<script type="text/javascript" src="./js/ajaxfileupload.js"></script>
<script type="text/javascript" src="./js/index.js"></script>
</body>
</html>