<style>
    .e-btn-close {
    box-sizing: content-box;
    width: 1em;
    height: 1em;
    padding: 0.25em 0.25em;
    color: #fff;
    background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 16 16'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    border: 0;
    border-radius: 0.25rem;
    opacity: 0.5;
    cursor: pointer;
  }

  .e-btn-close:hover {
    color: #fff;
    text-decoration: none;
    opacity: 0.75;
  }

  .e-btn-close:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(203, 12, 159, 0.25);
    opacity: 1;
  }

  .e-btn-close:disabled,
  .e-btn-close.disabled {
    pointer-events: none;
    user-select: none;
    opacity: 0.25;
  }

  .e-btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
  }

  .alert-dismissible .e-btn-close {
  position: absolute;
  top: 0;
  right: 0;
  z-index: 2;
  padding: 1.25rem 1rem;
  }
  .toast-header .btn-close {
    margin-right: -0.375rem;
    margin-left: 0.75rem;
  }

  .modal-header .btn-close {
    padding: 0.5rem 0.5rem;
    margin: -0.5rem -0.5rem -0.5rem auto;
  }

  .offcanvas-header .btn-close {
    padding: 0.5rem 0.5rem;
    margin: -0.5rem -0.5rem -0.5rem auto;
  }

  .e-modal-title {
    margin-bottom: 0;
    line-height: 1.5;
    font-weight: 600;
    font-size: 1rem;
    color: #252f40;
    margin-top: 0;
  }

  </style>
  <!--QR js -->
  <script src="{{ asset('vendor') }}/qr/qrcode.min.js"></script> 