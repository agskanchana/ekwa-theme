<div class="footer-icons">
    <ul>

        <li>
        <a   <?php if( isset( $_COOKIE['adward_number'] ) || isset( $_GET['ads'] ) ):?> href="tel:<?php echo mobile_number(get_theme_mod('adsense_number'));?>" <?else:?> href="#menu3" <?php endif;?>>
                <span class="icon">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
</svg>                </span>
                <span class="icon-name">Call </span>
            </a>
        </li>

        <li>
            <a href="<?php echo esc_url( get_appointment_link() ); ?>">
                <span class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                </span>
                <span class="icon-name">Appointment</span>
            </a>
        </li>
		<li>
			<a title="scrollup" class="scrollup" href="#">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M9.414 8l8.607 8.607-1.414 1.414L8 9.414V17H6V6h11v2z" fill="rgba(255,255,255,1)"/></svg>
			</a>
		</li>

        <li>
            <a href="#menu2" class="treatment-m-menu">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"/><path d="M16 1c.552 0 1 .448 1 1v3h4c.552 0 1 .448 1 1v14c0 .552-.448 1-1 1H3c-.552 0-1-.448-1-1V6c0-.552.448-1 1-1h4V2c0-.552.448-1 1-1h8zm4 6H4v12h16V7zm-7 2v3h3v2h-3.001L13 17h-2l-.001-3H8v-2h3V9h2zm2-6H9v2h6V3z" fill="rgba(255,255,255,1)"/></svg>                </span>
                <span class="icon-name">Treatments</span>
            </a>
        </li>
        <li>
            <a target="_blank" rel="nofollow noreferrer" href="<?php echo get_location('direction');?>">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
</svg>
						</svg>
                </span>
                <span class="icon-name">Find us</span>
            </a>
        </li>

    </ul>
</div>
<style>
    .footer-icons{
        --footer-icons-bg: <?php ekwa_get_value('mobile-icons-bg', '#2e9fc4');?>;
        --footer-icons-color: <?php ekwa_get_value('mobile-icons-color', '#fff');?>;
    }
    .footer-icons{
        z-index: 1500;
        position: fixed;
        /*display: none;*/

        width: 100%;
        bottom: 0;
        background: var(--footer-icons-bg);
    }
    .footer-icons ul{
        list-style: none;
        padding-left: 0;
        margin: 0;
        display: flex;
        justify-content: space-evenly;
    }
    .footer-icons ul li{
        display: block;
        width: 20%;
        text-align: center;
    }
    .footer-icons ul li a{
        display: block;
         padding-top: 10px;
        padding-bottom: 16px;
        color: var(--footer-icons-color);
        text-decoration: none !important;
    }
    .footer-icons ul li a.treatment-m-menu svg{
        fill: var(--footer-icons-color);
    }
    .footer-icons ul li a:hover{
        text-decoration: none;
    }
    .footer-icons ul li a span{
        display: block;
    }
    .footer-icons ul li a span.icon{
        font-size: 20px;
    }
    .footer-icons ul li a span.icon-name{
        font-size: 12px;
        text-transform: uppercase;
    }
    .footer-icons ul li a span.icon svg{
        height: 25px;
            margin-bottom: 5px;
    }


    @media screen and (min-width: 1024px){
        .footer-icons{
            display: none;
        }

    }
@media screen and (max-width: 1023px){
    .scrollup {
        bottom: 52px;
        display: block;
        height: 45px;
        position: fixed;
        right: 0;
        left: 0;
        margin-left: auto;
        margin-right: auto;
        width: 45px;
        background: var(--footer-icons-bg);
        z-index: 1500;
        color: #ffffff !important;
        border: 2px solid #ffffff;
        line-height: 20px;
        font-size: 20px;
        text-align: center;
        transform: rotate(44deg);
        border-radius: 6px;
}
	.scrollup i{
		transform: rotate(-45deg);
	}
}
    @media screen and (max-width: 480px){
        .footer-icons ul li a span.icon-name{
            font-size: 9px;
        }
        .footer-icons ul li a span.icon{
            font-size: 18px;
        }
        .footer-icons ul li a span.icon svg{
            height: 22px;
        }
		.scrollup{
			bottom: 44px;
		}
    }
	@media screen and (max-width: 379px){
     .footer-icons ul li a span.icon-name{
            font-size: 8px;
        }
}
</style>