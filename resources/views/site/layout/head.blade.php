<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{isset($title) ? $title : ($shopSetting->title ?? "")}} - F99 Price</title>
<meta name="csrf-token" content="{{ csrf_token() }}" />