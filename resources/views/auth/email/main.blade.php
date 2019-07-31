<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>{{ env('APP_NAME', 'System') }}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link href="https://fonts.googleapis.com/css?family=Battambang|Suwannaphum&display=swap" rel="stylesheet">
  <style type="text/css">
  /* FONTS */
  @media screen {
    @font-face {
      font-family: 'Lato';
      font-style: normal;
      font-weight: 400;
      src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
    }

    @font-face {
      font-family: 'Lato';
      font-style: normal;
      font-weight: 700;
      src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
    }

    @font-face {
      font-family: 'Lato';
      font-style: italic;
      font-weight: 400;
      src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
    }

    @font-face {
      font-family: 'Lato';
      font-style: italic;
      font-weight: 700;
      src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
    }
  }

  /* CLIENT-SPECIFIC STYLES */
  body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
  table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
  img { -ms-interpolation-mode: bicubic; }

  /* RESET STYLES */
  img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
  table { border-collapse: collapse !important; }
  body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; font-family: 'Battambang', 'Roboto', sans-serif !important; }

  blockquote {
    font-weight: 100;
    font-size: 14px;
    max-width: 600px;
    line-height: 1.4;
    position: relative;
    margin: 0;
    padding: .5rem;
  }

  blockquote:before,
  blockquote:after {
    position: absolute;
    color: #f1efe6;
    font-size: 6rem;
    width: 4rem;
    height: 4rem;
  }

  blockquote:before {
    content: '“';
    left: -5rem;
    top: -2rem;
  }

  blockquote:after {
    content: '”';
    right: -5rem;
    bottom: 1rem;
  }


  /* iOS BLUE LINKS */
  a[x-apple-data-detectors] {
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
  }

  /* ANDROID CENTER FIX */
  div[style*="margin: 16px 0;"] { margin: 0 !important; }
</style>
</head>
<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">

  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- LOGO -->
    <tr>
      <td bgcolor="#006df0" align="center">
        <table border="0" cellpadding="0" cellspacing="0" width="480" >
          <tr>
            <td align="center" valign="top" style="padding: 40px 10px 40px 10px;">
              <a href="{{ url('/') }}" target="_blank">
                <img alt="{{ config('app.name') }}" src="{{ asset('img/logo/logo.png') }}" width="100" height="100" style="display: block;  font-family: 'Lato', Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
              </a>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    @yield('content')

    <!-- FOOTER -->
    <tr>
      <td bgcolor="#f4f4f4" align="center" style="padding: 10px 10px 0px 10px;">
        <table border="0" cellpadding="0" cellspacing="0" width="480" >
          <!-- HEADLINE -->
          <tr>
            <td bgcolor="#FFFFFF" align="center" style="padding: 30px 10px 30px 10px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
              <p><h4 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">Keep in touch with us:</h4></p>
              <div display="block" style="margin-top: 15px; box-sizing: border-box; position: static; border-radius: 0; -webkit-transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); overflow: inherit; padding: 0rem 0rem 0rem 0rem; margin: 0rem 0rem 0rem 0rem; border-top: none; border-right: none; border-bottom: none; border-left: none; display: block;">
                <a href="{{ url('/') }}" color="blue" scale="1" target="_blank" style="background-color: transparent; color: #006df0; cursor: pointer; display: inline-block; font-weight: 700; max-width: 100%; overflow: hidden; text-decoration: none; text-decoration-skip: ink; text-overflow: ellipsis; -webkit-transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); vertical-align: bottom; font-size: 16px; line-height: 1.5;">{{ config('app.name') }}
                </a>
                <span style="margin-left:1em;margin-right:1em;">·</span>

                <a href="https://www.facebook.com/" color="blue" scale="1" target="_blank" style="background-color: transparent; color: #006df0; cursor: pointer; display: inline-block; font-weight: 700; max-width: 100%; overflow: hidden; text-decoration: none; text-decoration-skip: ink; text-overflow: ellipsis; -webkit-transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); vertical-align: bottom; font-size: 16px; line-height: 1.5;">Facebook
                </a>
                <span style="margin-left:1em;margin-right:1em;">·</span>

                <a href="https://twitter.com/" color="blue" scale="1" target="_blank" style="background-color: transparent; color: #006df0; cursor: pointer; display: inline-block; font-weight: 700; max-width: 100%; overflow: hidden; text-decoration: none; text-decoration-skip: ink; text-overflow: ellipsis; -webkit-transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); transition: all 300ms cubic-bezier(0.19, 1, 0.22, 1); vertical-align: bottom; font-size: 16px; line-height: 1.5;">Twitter
                </a>

              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td bgcolor="#f4f4f4" align="center" style="padding: 10px 10px 0px 10px;">
        <table border="0" cellpadding="0" cellspacing="0" width="480" >
          <!-- ADDRESS -->
          <tr>
            <td bgcolor="#f4f4f4" align="left" style="text-align: center; padding: 0px 30px 30px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;" >
              <p style="margin-top: 5px;">Copyright © {{date('Y')}}, <a href="{{ url('/') }}" target="_blank">{{ config('app.name') }}</a>. All rights reserved.</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>

  </table>

</body>
</html>
