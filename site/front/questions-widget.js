(function(){
    // let formActiveData; ///= $('.questions-form').;

    function initForm() {
        let form = $('.questions-form');
        form.find('.form-select').barrating({theme:'css-stars'});
        form.on({
            submit(e) { e.preventDefault(); },
            beforeSubmit(e) {
                let formActiveData = form.yiiActiveForm('data');

                formActiveData.attributes.forEach((el, ind) => {
                    formActiveData.attributes[ind].status = 0;
                });
                console.log(formActiveData, 'data');
                let fd = new FormData(form[0]);
                fetch(form.attr('action'), {
                    method: 'post',
                    body: fd,
                }).then(res => res.text()).then(ret => {
                    form.replaceWith(ret);
                    form = initForm();
                    form.yiiActiveForm('init', formActiveData.attributes, formActiveData.settings);
                });
                console.log('submit');
            }
        });
        return form;
    }

    initForm();

    console.log('ds');
})(jQuery)