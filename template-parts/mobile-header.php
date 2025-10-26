<!-- Header -->
  <div class="mheader" id="mheader">
    <div class="mobile-logo">
      <a href="<?php echo get_option( 'siteurl' );?>"><?php  mobile_logo();?></a>
    </div>
    <div class="m-header-col">
      <div class="search-icon" style="margin-top: 8px;">
      <svg width="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
      </div>
      <a class="mmenu-trigger" aria-label="mobile-menu" href="#my-menu">
        <span class="hamburger-wrapper">
        <div class="hamburger is-lg">
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
          </div>
        </span>
      </a>
    </div>
  </div>

<style>
  .mheader{
    --mobile-header-bg: <?php ekwa_get_value('mobile-header-bg', '#fff');?>;
    --hamburger-menu-bg: <?php ekwa_get_value('mobile-icon-bg', '#092c3e');?>;
    --hamburger-icon: <?php ekwa_get_value('mobile-icon-color', '#fff');?>;
  }

.mheader{
  position: relative;
  padding-top: 20px;
  padding-bottom: 20px;
  background: var(--mobile-header-bg);
  display: flex;
  justify-content: space-between;
}
.search-icon{
  cursor: pointer;
  max-width: 25px;
  flex: 25px;
}
.hamburger {
  position: relative;
  width: 1em;
  height: 1em;
  font-size: inherit;
  /* transition: all 0.3s ease; */
  cursor: pointer;
  font-size: 1.6rem;
}
.hamburger-line {
  position: absolute;
  right: 0;
  width: 100%;
  height: 0.125em;
  border-radius: 0.125em;
  background: var(--hamburger-menu-bg);
  transition: inherit;
}
.hamburger-line:nth-child(1) {
  top: 0.125em;
}
.hamburger.is-active .hamburger-line:nth-child(1), .w-nav-button.w--open .hamburger-line:nth-child(1) {
  top: 50%;
  transform: translateY(-50%) rotateZ(-135deg);
}
.hamburger-line:nth-child(2) {
  top: 0.438em;
}

.hamburger-line:nth-child(3) {
  top: 0.75em;
  width: 0.625em;
}

.m-header-col{
  flex: 0 0 150px;
  max-width: 150px;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 10px;
  padding-right: 10px;
}
/*
.mmenu-trigger{

  display: block;
  top: 0;
  right: 0;
  width: 100px;
  background: var(--hamburger-menu-bg);
  height: 100%;
}
.hamburger-wrapper{
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  display: block;
  margin: auto;
  left: 0;
  right: 0;
}
.hamburger-wrapper .menu-text{
  display: block;
  text-align: center;
  text-transform: uppercase;
  font-size: 12px;
  margin-top: 5px;
  display: block;
  color: var(--hamburger-icon);
}
.hamburger{
  height: 24px;
  width: 30px;
  border-top: 2px solid var(--hamburger-icon);
  border-bottom: 2px solid var(--hamburger-icon);
  position: relative;
  margin-left: auto;
  margin-right: auto;
  text-align: center;
  display: block;
}
.hamburger:after{
  position: absolute;
  height: 2px;
  width: 100%;
  background: var(--hamburger-icon);
  top: 50%;
  transform: translateY(-50%);
  content: "";
  display: block;

}*/
.mobile-logo{
  margin-left: 20px;
}
.mobile-logo img{
  width: 100%;
}
@media screen and (max-width: 480px){
    .mobile-logo{
      width: 200px;
    }
}
@media screen and (min-width: 480px){
    .mobile-logo{
      width: 230px;
    }
}
@media screen and (min-width: 1024px){
    .mheader{
      display: none;
    }
}
</style>

  <!--/Header-->