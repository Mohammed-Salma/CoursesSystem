<h2>مرحبا {{ $data['name'] }}</h2>
<P>بريدك الالكتروني {{ $data['email'] }}</P>
<P>المستوي الدراسي {{ $data['level'] }}</P>
<h4>الكورسات</h4>
<ul>
    @foreach ($data['courses'] as $course)
        <li>{{ $course }}</li>
    @endforeach
</ul>
<h5 style='color:green;'>شكرا لاشتراكك معنا</h5>

{{-- معلش يعني بس ده يبقا m0hamedsoft@123456 --}}
