<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <style>
        .br {
            display: inline-block;
            padding: 2px;
            border: 1px solid #ccc;
            background: #fff;
            text-align: center;
        }
    </style>
</head>
<body>
<div>
    <ul id="list">
        <li></li>
    </ul>

    <a href="#" class="page br" data-index="0">1</a>
    <a href="#" class="page br" data-index="1">2</a>
    <a href="#" class="page br" data-index="2">3</a>

    <a href="#" class="ajax br">ajax</a>
</div>
</body>
<script type="text/tiscript">
    view.root.on("ready", function() {
        //注意这里getData方法，我们是在主窗口注册的
        //通过view.window创建的子窗口，我们需要通过view.parent访问父级来调用getData
        var params = {};
        params.index = -1;
        var data = view.parent.getData(JSON.stringify(params));
        //解析从后台传来的数据
        data = JSON.parse(data);

        if (data) {
            var html = "";
            for(var (k, v) in data) {
                html += "<li>" + v.name + "---" + v.age + "</li>";
            }
            $(#list).html = html;
        }
    });

    self.on("click", ".page", function() {
        var index = this.attributes["data-index"];
        var params = {};
        params.index = index;
        var data = view.parent.getData(JSON.stringify(params));
        data = JSON.parse(data);
        if (data) {
            var html = "";
            for(var (k, v) in data) {
                html += "<li>" + v.name + "---" + v.age + "</li>";
            }
            $(#list).html = html;
        }
    });

    self.on("click", ".ajax", function() {
        view.request({
            type: #get,
            url: "http://127.0.0.1",
            protocol: #basic,
            params: {
                "test": "test"
            },
            //设置返回数据类型为json
            output: #json,
            //成功回调函数
            success: function(data,status) {
                if (data) {
                    var html = "";
                    for(var (k, v) in data) {
                        html += "<li>" + v.name + "---" + v.age + "</li>";
                    }
                    $(#list).html = html;
                }
            },
            //失败回调函数
            error: function(err,status) {
                view.msgbox(#alert, err);
            }
        });
    });

</script>
</html>