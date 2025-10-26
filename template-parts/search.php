<!-- Overlay for popup -->
<div id="overlay" class="overlay"></div>

<div id="search-popup" class="search-popup">
          <form role="search" method="get" action="<?php echo get_option('siteurl'); ?>">
            <div class="search-input-container">
              <input type="search" id="search-input" value="" name="s" placeholder="Type to search..." />
              <input type="submit" class="submit-btn" value="Search" />
            </div>
          </form>
        </div>

<!-- Close Button positioned in top-right corner of the viewport -->
<button id="close-btn" class="close-btn">&times;</button>


<style>


.search-icon{
    cursor: pointer;
}
/* Overlay with blurred background */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(8px);
  display: none;
  opacity: 0;
  transition: opacity 0.5s ease;
  z-index: 999;
}

/* Popup with drop-down and fade-in effect */
@keyframes dropDown {
  from {
    transform: translate(-50%, -60%) scale(0.9);
    opacity: 0;
  }
  to {
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;
  }
}

@keyframes fadeOut {
  from {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
  }
  to {
    opacity: 0;
    transform: translate(-50%, -60%) scale(0.9);
  }
}

.search-popup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -60%);
  width: 90%;
  max-width: 450px;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0px 8px 32px rgba(0, 0, 0, 0.3);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  display: none;
  opacity: 0;
  z-index: 1000;
}

.search-popup.active {
  display: block;
  animation: dropDown 0.5s ease forwards;
}

.search-popup.fade-out {
  animation: fadeOut 0.5s ease forwards;
}

.close-btn {
  position: fixed;
  top: 20px;
  right: 20px;
  font-size: 24px;
  background: #000;
  border: none;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  color: white;
  cursor: pointer;
  z-index: 1001;
  display: none;
  transition: background-color 0.3s ease, transform 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.close-btn:hover {
  /* background-color: #ff0000; */
  /* transform: scale(1.1); */
}

.close-btn:focus {
  outline: none;
}


.search-input-container {
  position: relative;
  display: flex;
  align-items: center;
}


#search-input {
  width: calc(100% - 60px);
  padding: 12px;
  border-radius: 8px 0 0 8px;
  border: 1px solid #ccc;
  outline: none;
  font-size: 16px;
  color: #333;
  background-color: rgba(255, 255, 255, 0.95);
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}



.submit-btn {
  padding: 12px 15px;
  background-color: white;
  color: #333;
  border: 1px solid #ccc;
  border-radius: 0 8px 8px 0;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease, transform 0.3s ease;
  margin-left: -1px;
}

.submit-btn:hover {
  background-color: #e0e0e0;
  transform: scale(1.05);
}


.overlay.active {
  display: block;
  opacity: 1;
}


.close-btn.active {
    display: flex;
    justify-content: center;
    align-items: center;
}


</style>