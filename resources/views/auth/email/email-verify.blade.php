@extends('auth.email.main')

@section('content')
<!--  -->
<tr>
  <td bgcolor="#006df0" align="center" style="padding: 0px 10px 0px 10px;">
    <table border="0" cellpadding="0" cellspacing="0" width="480" >
      <tr>
        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
          <h1 style="font-size: 32px; font-weight: 400; margin: 0;">{{ __('Email verification') }}</h1>
        </td>
      </tr>
    </table>
  </td>
</tr>
<!--  -->
<tr>
  <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
    <table border="0" cellpadding="0" cellspacing="0" width="480" >
      <!--  -->
      <tr>
        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;" >
          <p style="margin-top: 10px; margin-bottom: 20px;">
            @if($info->name)
            Dear {{ $info->name }},
            @else
            Hello,
            @endif</p>
            <p style="margin: 0;"> {{ __('We received a request to verify your email address. Please click the button "Verify now!" to verify your email address to make sure your email is active.') }}</p>
          </td>
        </tr>
        <!-- BULLETPROOF BUTTON -->
        <tr>
          <td bgcolor="#ffffff" align="left">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                  <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" style="border-radius: 3px;" bgcolor="#006df0"><a href="{{ route('email.verify', ['token' => $info->verify_token]) }}" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #006df0; display: inline-block;">Verify now!</a></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <!--  -->
  <tr>
    <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
      <table border="0" cellpadding="0" cellspacing="0" width="480" >
        <!-- HEADLINE -->
        <tr>
          <td bgcolor="#006df0" align="left" style="padding: 40px 30px 20px 30px; color: #ffffff; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;" >
            <h2 style="font-size: 24px; font-weight: 400; margin: 0;">{{ __('Unable to click on the button above?') }}</h2>
          </td>
        </tr>
        <!--  -->
        <tr>
          <td bgcolor="#006df0" align="left" style="padding: 0px 30px 20px 30px; color: #ffffff; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;" >
            <p style="margin: 0;">{{ __('Click on the link below or copy/paste in the address bar.') }}</p>
          </td>
        </tr>
        <!--  -->
        <tr>
          <td bgcolor="#006df0" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #ffffff; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;" >
            <p style="margin: 0;"><a href="{{ route('email.verify', ['token' => $info->verify_token]) }}" target="_blank" style="color: #ffffff;">{{ route('email.verify', ['token' => $info->verify_token]) }}</a></p>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td bgcolor="#f4f4f4" align="center" style="padding: 10px 10px 0px 10px;">
      <table border="0" cellpadding="0" cellspacing="0" width="480" >

        <!-- PERMISSION REMINDER -->
        <tr>
          <td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;" >
            <p style="margin: 0;">{{ __('Please verify your email within 24 hours, otherwise, the link will be expired.') }}</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td bgcolor="#f4f4f4" align="center" style="padding: 10px 10px 0px 10px;">
      <table border="0" cellpadding="0" cellspacing="0" width="480" >
        <tr>
          <td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 18px;" >
            <p style="margin: 0;">Support Team</p>
            <p style="margin-top: 5px;">{{ env('APP_NAME', '')}}</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  @endsection
