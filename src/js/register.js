$(document).ready(function () {
    let passInput = $('input#password');
    let lengthRule = $('#rule-length');
    let upperRule = $('#rule-upper');
    let digitRule = $('#rule-digit');

    // управляем правилами валидации паролей
    passInput.on('input', e => {
        let pass = passInput.val();
        if (pass.length < 8) {
            lengthRule.addClass('invalid');
            lengthRule.prev().removeClass('valid');
        } else {
            lengthRule.removeClass('invalid');
            lengthRule.prev().addClass('valid');
        }
        if (!/[A-ZА-Я]/.test(pass)) {
            upperRule.addClass('invalid');
            upperRule.prev().removeClass('valid');
        } else {
            upperRule.removeClass('invalid');
            upperRule.prev().addClass('valid');
        }
        if (!/\d/.test(pass)) {
            digitRule.addClass('invalid');
            digitRule.prev().removeClass('valid');
        } else {
            digitRule.removeClass('invalid');
            digitRule.prev().addClass('valid');
        }
    });

    let passConfirmationInput = $('#password_confirmation');

    // при подтверждении формы, проверяем, валидны ли пароли
    $('#register').on('submit', e => {
        let prevent = false;
        if (lengthRule.hasClass('invalid') || upperRule.hasClass('invalid') || digitRule.hasClass('invalid') || sameRule.hasClass('invalid')) {
            $('.password-rules .rule.invalid').addClass('bigger-rule-text');
            setTimeout(() => {
                $('.password-rules .rule.invalid').removeClass('bigger-rule-text');
            }, 200)
            prevent = true;
        }
        if (prevent) {
            e.preventDefault();
        }
    });


    // это вообще в отдельный файл js надо, чтобы переиспользовать в профиле
    let fileInput = $('#input-file'),
        fileLabel = $('#label-file'),
        fileLabelVal = fileLabel.html();

    fileInput.on('change', function (e) {
        let fileName = e.target.value.split('\\').pop();
        if (fileName) {
            fileLabel.html(fileName);
        }
    });

    fileInput.on('focus', function () {
        fileInput.addClass('has-focus');
    }).on('blur', function () {
        fileInput.removeClass('has-focus');
    });

});

