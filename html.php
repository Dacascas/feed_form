<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Форма обратной связи</title>
    <link rel="stylesheet" media="screen" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.min.css">
    <style>
        body {
            font-size: 62.5%;
        }
        label {
            display: inline-block;
            width: 100px;
        }
        legend {
            padding: 0.5em;
        }
        fieldset fieldset label {
            display: block;
        }
        #commentForm {
            width: 500px;
        }
        #commentForm label {
            width: 250px;
        }
        #commentForm label.error, #commentForm button.submit {
            margin-left: 253px;
        }
        .ui-state-highlight{
            color:darkred !important;
            border-color: red !important;
        }
    </style>
</head>
<body>
<form class="cmxform" id="commentForm" method="post" action="">
    <fieldset class="ui-widget ui-widget-content ui-corner-all">
        <legend class="ui-widget ui-widget-header ui-corner-all">Форма обратной связи</legend>
        <?php
            if(count($m) > 0){
                echo implode(', </ br>', $m);
            }
        ?>
        <p>
            <label for="cemail">E-Mail</label>
            <input id="cemail" name="email" class="ui-widget-content" required type="email" placeholder="example@domain.com">
        </p>
        <p>
            <label for="cname">Имя</label>
            <input id="cname" name="name" class="ui-widget-content" type="text">
        </p>

        <p>
            <label for="cphone">Телефон</label>
            <input id="cphone" name="phone" class="ui-widget-content" required value="" type="text" placeholder="+380(__)___-__-__ ">
        </p>
        <p>
            <label for="ccomment">Обращение</label>
            <textarea id="ccomment" name="comment" minlength="10" class="ui-widget-content" required></textarea>
        </p>
        <p>
            <button class="submit" type="submit">Сохранить</button>
        </p>
    </fieldset>
</form>
<script src="js/jquery.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script>
    $.validator.setDefaults({
        submitHandler: function(form) {
            //alert("submitted!");
            $(form).ajaxSubmit();
        },
        showErrors: function(map, list) {
            // there's probably a way to simplify this
            var focussed = document.activeElement;
            if (focussed && $(focussed).is("input, textarea")) {
                $(this.currentForm).tooltip("close", {
                    currentTarget: focussed
                }, true)
            }
            this.currentElements.removeAttr("title").removeClass("ui-state-highlight");
            $.each(list, function(index, error) {
                $(error.element).attr("title", error.message).addClass("ui-state-highlight");
            });
            if (focussed && $(focussed).is("input, textarea")) {
                $(this.currentForm).tooltip("open", {
                    target: focussed
                });
            }
        }
    });

    (function() {
        // use custom tooltip; disable animations for now to work around lack of refresh method on tooltip
        $("#commentForm").tooltip({
            show: false,
            hide: false
        });

        $("#commentForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                comment: {
                    required: true,
                    minlength: 10
                },
                phone: {
                    required: true,
                    regexp:true
                }
            },
            messages: {
                email: "Пожалуйста, введите действительный адрес электронной почты",
                comment: {
                    required: "Пожалуйста, введите обращение",
                    minlength: "Ваше обращение должно состоять как минимум из 10 символов"
                },
                phone: {
                    required: "Введите номер в формате +380(__)___-__-__ ",
                    regexp: "Введите телефон в правильном формате +380(__)___-__-__"
                }
            }
        });

        $(":submit").button();
    })();
    jQuery.validator.addMethod("regexp", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && phone_number.match(/^\+380\([\d]{2}\)[\d]{3}-[\d]{2}-[\d]{2}$/);;
    }, "Пожалуйста, укажите действующий номер телефона");
</script>
</body>
</html>