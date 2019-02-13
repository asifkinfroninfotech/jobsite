@php
$p_color=session('tenant_primary_color');
$s_color=session('tenant_secondary_color');
@endphp

<p class="copy-right text-center">
    &copy; Copyright {{date('Y')}} {{session('tenant_company')}}. All rights reseved.
</p>
<p class="copy-right text-center">
    Powered by ARTHA
</p>


<script type="text/javascript">
    $(document).ready(function () {

        Call_ColorChange();


    });


    function Call_ColorChange() {
        var p_color = "{{session('tenant_primary_color')}}";
        var s_color = "{{session('tenant_secondary_color')}}";

        if (typeof p_color != 'undefined' && p_color != '') {
            colorReplace("#3399ff", p_color); //"#f48220"
        }

        if (typeof s_color != 'undefined' && s_color != '') {
            colorReplace("#b11f37", s_color); //"#000"
        }
    }






    function colorReplace(findHexColor, replaceWith) {
        // Convert rgb color strings to hex
        function rgb2hex(rgb) {
            if (/^#[0-9A-F]{6}$/i.test(rgb)) return rgb;
            rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

            function hex(x) {
                return ("0" + parseInt(x).toString(16)).slice(-2);
            }
            return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
        }

        // Select and run a map function on every tag
        $('*').map(function (i, el) {
            // Get the computed styles of each tag
            var styles = window.getComputedStyle(el);

            // Go through each computed style and search for "color"
            Object.keys(styles).reduce(function (acc, k) {
                var name = styles[k];
                var value = styles.getPropertyValue(name);
                if (typeof name === 'undefined' || name === null) {} else {
                    if (name.indexOf("color") >= 0) {
                        // Convert the rgb color to hex and compare with the target color
                        if (value.indexOf("rgb(") >= 0 && rgb2hex(value) === findHexColor) {
                            // Replace the color on this found color attribute
                            $(el).css(name, replaceWith);
                        }
                    }
                }
            });
        });
    }
    // Call like this for each color attribute you want to replace
</script>