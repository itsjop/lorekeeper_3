<script>
    $(document).ready(function() {
        $('#charTitle').selectize();

        let titles = JSON.parse('{!! json_encode($titles) !!}');
        let $title = $('#charTitle');
        let $titleOptions = $('#titleOptions');
        let $titleDataForm = $('.title-data');

        $title.on('change', function(e) {
            updateTitleEntry($title.val());
        });

        function updateTitleEntry(titleEntries) {
            oldForms = $('#titleData').find('input');
            oldForms = oldForms.map(function() {
                let name = $(this).attr('name');
                let val = $(this).val();
                return {
                    name: name,
                    val: val
                };
            });
            $('#titleData').html('');
            if (titleEntries && titleEntries.length > 0 && titleEntries[0] != 0) {
                $titleOptions.removeClass('hide');
                titleEntries.forEach(title => {
                    let titleName = titles[title.trim()];
                    if (titleName) {
                        let newForm = $titleDataForm.clone();
                        newForm.removeClass('hide original');
                        newForm.find('.title-name').text(titleName);
                        var inputs = newForm.find('input');
                        inputs.each(function() { // Use .each() instead of .forEach()
                            let oldName = $(this).attr('name');
                            $(this).attr('name', 'title_data[' + title + '][' + oldName + ']');

                            let newName = $(this).attr('name');
                            let matchingOldForm = oldForms.filter(function() {
                                return this.name == newName;
                            });

                            if (matchingOldForm.length > 0) {
                                $(this).val(matchingOldForm[0].val);
                            }
                        });

                        $('#titleData').append(newForm);
                    }
                });
            } else {
                $titleOptions.addClass('hide');
            }
        }
    });
</script>
