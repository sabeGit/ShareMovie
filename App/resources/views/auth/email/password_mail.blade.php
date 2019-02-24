{{ $name }}様、以下のURLから、パスワードを再設定してください。<br>
<a href="{{!! url('password/reset/'.$token) !!}}">{{ url('password/reset/'.$token) }}</a>
