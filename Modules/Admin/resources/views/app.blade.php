<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>Laravel后台管理模板</title>
    @vite('resources/css/tailwind.css')
    @vite('Modules/Admin/resources/assets/js/app.js')
    @routes
    @inertiaHead
</head>

<body>
    @inertia
    {{-- 弹窗容器，一些arco弹窗会改变body宽度为窗口宽度，这在iframe页面中会导致页面变形，如果遇到这问题，可以将挂载容器指向此元素试试 --}}
    <div id="popup-container"></div>
</body>

</html>