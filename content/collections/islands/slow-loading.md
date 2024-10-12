---
id: 7a22fe4d-5e5e-41c0-9770-554815ea19cc
blueprint: island
title: slow-loading
placeholder:
  code: |-
    <div slot="loading" hidden>
         <div class="skeleton" style="width:90%;"></div>
         <div class="skeleton" style="width:55%;"></div>
    </div>
  mode: handlebars
updated_by: 225d58b0-3de7-45fb-b9a6-a2f543c6834c
updated_at: 1728763735
head:
  code: '<script src="https://postman-echo.com/delay/20"></script>'
  mode: handlebars
body:
  code: '<blockquote>This content took some time to load.<br/>Thank you so much for your patience.</blockquote>'
  mode: handlebars
lazy_loading: true
content:
  code: |-
    <head>
      <script src="https://postman-echo.com/delay/10"></script>
    </head>
    <body>
      <p>
        This content took some time to load. Thank you so much for your patience.
        You can find the source code for this page on <a
          href="/loading/demo.html">loading/demo.html</a>.
      </p>
    </body>
  mode: handlebars
---
