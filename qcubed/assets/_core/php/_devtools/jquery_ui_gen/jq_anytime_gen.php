<?php
require('jq_control.php');

function jq_anytime_gen() {
	$jqControlGen = new JqControlGen();
	$objJqDoc = new JqDoc(null, 'AnyTime_picker', 'QAnyTimeBox', 'QTextBox');
	$options = array();
	$options[] = new Option('ajaxOptions', 'ajaxOptions', 'Options', null, "Options to pass to jQuery's \$.ajax()  method whenever the user dismisses a popup picker or selects a value in an inline picker.");
	$options[] = new Option('askEra', 'askEra', 'Boolean', 'False', "If true, buttons to select the era (BCE/CE) are shown on the year selector popup, even if the format  specifier does not include the era. If false, buttons to select the era are NOT shown, even if the format specifier includes the era. Normally, era buttons are only shown if the format string specifies the era.");
	$options[] = new Option('askSecond', 'askSecond', 'Boolean', 'False', "If false, buttons for number-of-seconds are not shown on the year selector popup, even if the format  specifier includes seconds. Normally, the buttons are shown if the format string specifies seconds.");
	$options[] = new Option('baseYear', 'baseYear', 'Integer', '1970', "the number to add to two-digit years if the \"%y\" format  specifier is used. By default, the MySQL convention  that two-digit years are in the range 1970 to 2069 is used. The most common alternatives are 1900 and 2000. When using this option, you should also specify the earliest and latest options to the first and last dates in the century, respectively. Refer to the ajaxOptions example.");
	$options[] = new Option('dayAbbreviations', 'dayAbbreviations', 'Array', '', "An array of day abbreviations to replace Sun, Mon, etc. Note:  if a different first day-of-week is specified by option firstDOW, this array should nonetheless start with the desired abbreviation for Sunday.");
	$options[] = new Option('dayNames', 'dayNames', 'Array', '', "An array of day names to replace Sunday, Monday, etc. Note:  if a different first day-of-week is specified by option firstDOW, this array should nonetheless start with the desired name for Sunday.");
	$options[] = new Option('earliest', 'earliest', 'Date', '', "String or Date object representing the earliest date/time that a user can select. If a String is specified, it is expected to match the format  specifier. For best results if the field is only used to specify a date, be sure to set the time to 00:00:00. Refer to the ajaxOptions  and extending examples.");
	$options[] = new Option('eraAbbreviations', 'eraAbbreviations', 'Array', '', "An array of era abbreviations to replace BCE and CE. The most common replacements are the obsolete: BC and AD.");
	$options[] = new Option('firstDOW', 'firstDOW', 'Integer', '0', "a value from 0 (Sunday) to 6 (Saturday) stating which day should appear at the beginning of the week. The default is 0  (Sunday). The most common substitution is 1 (Monday). Note:  if custom arrays are specified for dayAbbreviations and dayNames, they should nonetheless begin with the desired value for Sunday. Refer to the earlier popup examples.");
	$options[] = new Option('atDateTimeFormat', 'format', 'String', '%Y-%m-%d %T', "string specifying the date/time format");
	$options[] = new Option('formatUtcOffset', 'formatUtcOffset', 'String', '', "string specifying the format of the UTC offset choices displayed in the picker. Although all specifiers used by the format option are recognized, only those pertaining to UTC offsets (namely %#, %+, %-, %:, %;  and %@) should be used. By default, the picker will extrapolate a format by scanning the format  option for appropriate specifiers and their surrounding characters. Refer to the date/time picker  near the beginning of this page for an example.");
	$options[] = new Option('hideInput', 'hideInput', 'Boolean', 'False', "if true, the <input> is \"hidden\" (the picker appears in its place). This actually sets the border, height, margin, padding and width of the field as small as possible, so it can still get focus. Refer to the date/time picker  near the beginning of this page for an example. Note:  if you try to hide the field using traditional techniques (such as setting display:none), the picker will not behave correctly. This option should only be used with placement:\"inline\"; otherwise, a popup will only appear (seemingly from nowhere) if the user tabs to the hidden field. ");
	$options[] = new Option('labelDayOfMonth', 'labelDayOfMonth', 'String', '', "HTML to replace the Day of Month label");
	$options[] = new Option('labelDismiss', 'labelDismiss', 'String', '', "HTML to replace the dismiss popup button's X label");
	$options[] = new Option('labelHour', 'labelHour', 'String', '', "HTML to replace the Hour label. Refer to the earlier popup examples.");
	$options[] = new Option('labelMinute', 'labelMinute', 'String', '', "HTML to replace the Minute label. Refer to the earlier popup examples.");
	$options[] = new Option('labelMonth', 'labelMonth', 'String', '', "HTML to replace the Month label");
	$options[] = new Option('labelSecond', 'labelSecond', 'String', '', "HTML to replace the Second label");
	$options[] = new Option('labelTimeZone', 'labelTimeZone', 'String', '', "HTML to replace the Time Zone label");
	$options[] = new Option('labelTitle', 'labelTitle', 'String', '', "HTML for the title of the picker. If not specified, the picker automatically selects a title based on the format  specifier fields. Refer to the earlier popup examples.");
	$options[] = new Option('labelYear', 'labelYear', 'String', '', "HTML to replace the Year label");
	$options[] = new Option('latest', 'latest', 'Date', '', "String or Date object representing the latest date/time that a user can select. If a String is specified, it is expected to match the format  specifier. For best results if the field is only used to specify a date, be sure to set the time to 23:59:59. Refer to the ajaxOptions  and extending examples. ");
	$options[] = new Option('monthAbbreviations', 'monthAbbreviations', 'Array', '', "An array of month abbreviations to replace Jan, Feb, etc. Note:  do not use an HTML entity reference (such as &auml;) in a month name or abbreviation; embed the actual character (such as ä) instead. Be careful to save your source files under the correct encoding, or the character may not display correctly in all browsers; this often happens when a character code from UTF-8  is saved with ISO-8859-1 encoding (or vice-versa).");
	$options[] = new Option('monthNames', 'monthNames', 'Array', '', "An array of month names to replace January, February, etc.");
	$options[] = new Option('placement', 'placement', 'String', '', "One of the following strings: \n\"popup\": the picker appears above its input when the input receives focus, and disappears when it is dismissed. This is the default behavior.\n\"inline\": the picker follows the <input> and remains visible at all times. When choosing this placement, you might prefer to hide the input field using the hideInput option (the correct value will still be submitted with the form). Refer to the date/time picker near the beginning of this page for an example.");
	$objJqDoc->options = $options;
	$jqControlGen->GenerateControl($objJqDoc);
}

jq_anytime_gen();

?>
 
