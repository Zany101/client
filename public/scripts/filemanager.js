// const raw_url = location.protocol + '//' + location.host + location.pathname;
// const url = raw_url.substring(0, raw_url.length - +(raw_url.lastIndexOf('/') == raw_url.length - 1));

var extensions = {
  "groovy": "groovy",
  "ini": "properties",
  "properties": "properties",
  "css": "css",
  "scss": "css",
  "html": "htmlmixed",
  "htm": "htmlmixed",
  "shtm": "htmlmixed",
  "shtml": "htmlmixed",
  "xhtml": "htmlmixed",
  "cfm": "htmlmixed",
  "cfml": "htmlmixed",
  "cfc": "htmlmixed",
  "dhtml": "htmlmixed",
  "xht": "htmlmixed",
  "tpl": "htmlmixed",
  "twig": "htmlmixed",
  "hbs": "htmlmixed",
  "handlebars": "htmlmixed",
  "kit": "htmlmixed",
  "jsp": "htmlmixed",
  "aspx": "htmlmixed",
  "ascx": "htmlmixed",
  "asp": "htmlmixed",
  "master": "htmlmixed",
  "cshtml": "htmlmixed",
  "vbhtml": "htmlmixed",
  "ejs": "htmlembedded",
  "dust": "htmlembedded",
  "erb": "htmlembedded",
  "js": "javascript",
  "jsx": "javascript",
  "jsm": "javascript",
  "_js": "javascript",
  "vbs": "vbscript",
  "vb": "vb",
  "json": "javascript",
  "vdf": "clike",
  "xml": "xml",
  "svg": "xml",
  "wxs": "xml",
  "wxl": "xml",
  "wsdl": "xml",
  "rss": "xml",
  "atom": "xml",
  "rdf": "xml",
  "xslt": "xml",
  "xsl": "xml",
  "xul": "xml",
  "xbl": "xml",
  "mathml": "xml",
  "config": "xml",
  "plist": "xml",
  "xaml": "xml",
  "php": "php",
  "php3": "php",
  "php4": "php",
  "php5": "php",
  "phtm": "php",
  "phtml": "php",
  "ctp": "php",
  "c": "clike",
  "h": "clike",
  "i": "clike",
  "cc": "clike",
  "cp": "clike",
  "cpp": "clike",
  "c++": "clike",
  "cxx": "clike",
  "hh": "clike",
  "hpp": "clike",
  "hxx": "clike",
  "h++": "clike",
  "ii": "clike",
  "ino": "clike",
  "cs": "clike",
  "asax": "clike",
  "ashx": "clike",
  "java": "clike",
  "scala": "clike",
  "sbt": "clike",
  "coffee": "coffeescript",
  "cf": "coffeescript",
  "cson": "coffeescript",
  "_coffee": "coffeescript",
  "clj": "clojure",
  "cljs": "clojure",
  "cljx": "clojure",
  "pl": "perl",
  "pm": "perl",
  "rb": "ruby",
  "ru": "ruby",
  "gemspec": "ruby",
  "rake": "ruby",
  "py": "python",
  "pyw": "python",
  "wsgi": "python",
  "sass": "sass",
  "lua": "lua",
  "sql": "sql",
  "diff": "diff",
  "patch": "diff",
  "md": "markdown",
  "markdown": "markdown",
  "mdown": "markdown",
  "mkdn": "markdown",
  "yaml": "yaml",
  "yml": "yaml",
  "hx": "haxe",
  "sh": "shell",
  "command": "shell",
  "bash": "shell"
};

var config, editor, ext;

$.ajaxSetup({
    type: 'POST',
});


// remove files
// // Prepare JsPanel
// Object.assign(jsPanel.defaults, {
//     theme: 'bootstrap-dark',
//     border: 'medium',
//     onminimized: function (panel, status) {
//         panel.close(panel.id);
//     },
//     headerToolbar: [
//         '<i class="fas fa-save">Save</i>'
//         , '<span class="fas fa-save">Save & Exit</span>'
//         , '<span class="fas fa-search">Search</span>'
//     , ],
//
//     maximizedMargin: [65, 20, 20, 20],
//     minimizeTo: 'parent',
//     container: 'main',
//     // dragit : true,
//     background: 'red',
//     dragit: {
//         containment: [65, 20, 20]
//     }
// });

var contextMenuObj = {

}

$.contextMenu({
    selector: 'td',
    trigger: 'right',
    events: {
        show: function (options) {
            // Add class to the menu
            this.parent().toggleClass("selected");
        },
    },
    items: {
        rename: {
            name: "Rename",
            icon: "fas fa-pencil-alt",
        },
        edit: {
            name: "Edit",
            icon: "edit",
            visible: function(key, opt){
                // Hide this item if the menu was triggered on a div
                if(opt.$trigger[0].parentNode.attributes[3].nodeValue == 'dir'){
                  console.log("hellow");
                  return false;
                }
                return true;
            }
        },
        copy: {
            name: "Copy",
            icon: "copy"
        },
        delete: {
            name: "Delete",
            icon: "delete"
        },
    },
    callback: function (key, options) {

        // $(".selected")
        //     .removeClass("selected");

        var file = "",
            action = key,
            param = "?",
            item = $(this)
            .text(),
            parent = $(this);
        ext = item.substring(item.lastIndexOf(".") + 1);
        // Requires AJAX
        if (action == "rename") {
            $(this)
                .html(`<input class="form-control" type="text" name="" value="${item}">`);
            $('input')
                .focus()
                .select();
            $(this)
                .on('focusout', function () {
                    var val = $(this)
                        .children(1)
                        .val();
                    $(this)
                        .load(url + '/rename/' + item, {
                            name: val
                        });
                });
            return;
        }
        if (action == "edit") {

            $.ajax({
                url : url + "/" + action + "/" + item,
                success: function (html) {
                    jsPanel.create({
                        content: '<textarea id="editor">' + html.output + '</textarea>',
                        headerControls: {
                            smallify: 'remove'
                        },
                        // contentOverflow: 'hidden scroll',
                        theme: 'bootstrap-dark',
                        border: 'medium',
                        onminimized: function (panel, status) {
                            panel.close(panel.id);
                        },
                        headerToolbar: [
                            '<i class="fas fa-save">Save</i>'
                            , '<span class="fas fa-save">Save & Exit</span>'
                            , '<span class="fas fa-search">Search</span>'
                        , ],
                        callback: function (panel) {
                            // handler for the icons
                            // Save ajax
                            $("i.fas.fa-save", panel)
                                .on("click", function () {
                                    $.ajax({
                                            type: 'POST',
                                            url: url + '/save/' + item,
                                            data: {
                                                'test': editor.getValue()
                                            },
                                        })
                                        .done(function (data) {
                                            console.log(data);
                                        });
                                });
                        },
                        maximizedMargin: [65, 20, 20, 20],
                        headerTitle: item,
                        minimizeTo: 'parent',
                        container: 'main',
                        // dragit : true,
                        background: 'red',
                        dragit: {
                            containment: [65, 20, 20]
                        }
                    })
                }
            });

            return;

        }

        $.each($(".selected"), function (key, value) {
            if (key != 0) param = "&";
            file += param + "items[]=" + $(this).data('target');
        });

        return document.location = url + "/" + action + "/" + file;
    }

});


// assign handler to event
document.addEventListener('jspanelloaded', function (event) {

    editor = CodeMirror.fromTextArea(document.getElementById('editor'), {
        lineNumbers: true,
        lineWrapping: false,
        readOnly: false,
        allowDropFileTypes: true,
        theme: 'liquibyte',
        addModeClass: true,
        viewportMargin: 1,
        autocorrect: true,
        matchBrackets: true,
        mode: extensions[ext],
        indentWithTabs: true,
        height: '2px',
    });

    editor.setSize("100%", "100%");
}, false);
