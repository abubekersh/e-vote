<div>
    <h1>NATIONAL ELECTION BOARD OF ETHIOPIA</h1>
    <p>HELLO {{$voter->name}}</p>
    <p>As a result of your request for getting a new election token on {{$voter->token_request->created_at}}, your token is ready to use.</p>
    <p>here is the token keep it safe and know that it is only available ones</p>
    <h2>{{$voter->token}}</h2>
    <br><br><br>
    <p>if you still have problem with anything realted to the website you can contact us in the compliants section and submit your compliant or directly visit your neareast polling station</p>
</div>