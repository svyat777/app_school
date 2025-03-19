document.addEventListener("DOMContentLoaded", function () {
    const headers = document.querySelectorAll(".accordion-header");
  
    
    let savedState = JSON.parse(localStorage.getItem("accordionState")) || {};
  
    headers.forEach((button, index) => {
      const content = button.nextElementSibling;
      const arrow = button.querySelector(".arrow");
  
     
      if (savedState[index]) {
        content.style.maxHeight = content.scrollHeight + "px";
        button.classList.add("active");
        arrow.style.transform = "rotate(180deg)";
      } else {
        content.style.maxHeight = null;
        button.classList.remove("active");
        arrow.style.transform = "rotate(0deg)";
      }
  
    
      button.addEventListener("click", function () {
        const isOpen = button.classList.contains("active");
  
       
        headers.forEach((otherButton, otherIndex) => {
          if (otherButton !== button) {
            const otherContent = otherButton.nextElementSibling;
            otherContent.style.maxHeight = null;
            otherButton.classList.remove("active");
            otherButton.querySelector(".arrow").style.transform = "rotate(0deg)";
            savedState[otherIndex] = false;
          }
        });
  
       
        if (isOpen) {
          content.style.maxHeight = null;
          button.classList.remove("active");
          arrow.style.transform = "rotate(0deg)";
          savedState[index] = false;
        } else {
          content.style.maxHeight = content.scrollHeight + "px";
          button.classList.add("active");
          arrow.style.transform = "rotate(180deg)";
          savedState[index] = true;
        }
  
       
        localStorage.setItem("accordionState", JSON.stringify(savedState));
      });
    });
  });




