@props(['disabled' => false, 'field' => '', 'value' => ''])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'textarea form-control rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}
    >{{ $value }}</textarea>
@error($field)
    <div class="text-red-600 text-sm">{{ $message }}</div>
@enderror

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        let config =
            {
                linkShowAdvancedTab: false,
                scayt_autoStartup: true,
                removePlugins: 'elementspath',
                enterMode: Number(2),
                toolbar_Full: [['Styles', 'Bold', 'Italic', 'Underline', 'SpellChecker', 'Scayt', '-', 'NumberedList', 'BulletedList'],
                    ['Link', 'Unlink'], ['Undo', 'Redo', '-', 'SelectAll']]

            };

        $('textarea').ckeditor(config);

    });
</script>
