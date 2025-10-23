
@php
  use App\Models\UserManagement\MenuModel;
  use App\Helpers\UserManagementHelper;

@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ url('/home') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
          <span style="color: #666cff">
            <img src="{{ asset('images/logo/miegacoan.png') }}" alt="Mavora Logo" style="height: 40px; width: auto;">
          </span>
      </span>
      <span class="app-brand-text demo menu-text fw-semibold ms-2">Mie Gacoan</span>
    </a>

    <a href="{{ url('/home') }}" class="layout-menu-toggle menu-link text-large ms-auto">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z"
          fill-opacity="0.9" />
        <path
          d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z"
          fill-opacity="0.4" />
      </svg>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

<style>
  .menu-item.active > .menu-link {
  position: relative;
  background-color: #f5f5f9;
}

.menu-item.active > .menu-link::before {
  content: '';
  position: absolute;
  left: 0;
  top: 8px;
  bottom: 8px;
  width: 4px;
  background-color: #696cff;
  border-radius: 0 4px 4px 0;
}

</style>

  <ul class="menu-inner py-1">

    <li class="menu-item open">
      <a href="javascript:void(0);" class="menu-link menu-toggle" title="Master">
        <i class="menu-icon tf-icons ri-box-3-line"></i>
        <div data-i18n="Master">Master</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item ">
          <a href="{{ url('mie-gacoan-product')}}" class="menu-link" title="Product">
            <div data-i18n="Product">Product</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ url('mie-gacoan-bom')}}" class="menu-link" title="Bill of Material (BoM)">
            <div data-i18n="Bill of Material (BoM)">Bill of Material (BoM)</div>
          </a>
        </li>
      </ul>
    </li>

      <li class="menu-item open">
      <a href="javascript:void(0);" class="menu-link menu-toggle" title="Transaction">
        <i class="menu-icon tf-icons ri-price-tag-3-line"></i>
        <div data-i18n="Transaction">Transaction</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item ">
          <a href="{{ url('mie-gacoan-pos')}}" class="menu-link" title="Point Of Sale (POS)">
            <div data-i18n="Point Of Sale (POS)">Point Of Sale (POS)</div>
          </a>
        </li>
      </ul>
    </li>

  </ul>


</aside>
