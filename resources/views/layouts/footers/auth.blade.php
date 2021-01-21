<footer class="footer">
  <div class="container-fluid">
    <div class="copyright float-right">
      &copy; {{date('Y')}}&nbsp @if (!empty($setting->footer_text)){{__($setting->footer_text)}} @else {{__('All rights reserved.')}}@endif
    </div>
  </div>
</footer>