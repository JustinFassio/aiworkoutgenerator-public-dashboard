!function(){"use strict";var e={454:function(e,t,o){o.d(t,{UI:function(){return i}});class a{constructor(){this.initialized=!1}init(){this.initialized||(this.initializeComponents(),this.bindEvents(),this.initialized=!0)}initializeComponents(){this.initializeTabs(),this.initializeTooltips(),this.initializeModals()}bindEvents(){document.addEventListener("click",(e=>{e.target.matches(".athlete-dashboard-toggle")&&this.handleToggle(e),e.target.matches(".athlete-dashboard-modal-trigger")&&this.handleModalTrigger(e)}))}initializeTabs(){document.querySelectorAll(".athlete-dashboard-tabs").forEach((e=>{const t=e.querySelectorAll('[role="tab"]'),o=e.querySelectorAll('[role="tabpanel"]');t.forEach((a=>{a.addEventListener("click",(()=>{t.forEach((e=>e.setAttribute("aria-selected","false"))),o.forEach((e=>e.hidden=!0)),a.setAttribute("aria-selected","true");const i=e.querySelector(`#${a.getAttribute("aria-controls")}`);i&&(i.hidden=!1)}))})),t[0]&&t[0].click()}))}initializeTooltips(){document.querySelectorAll(".athlete-dashboard-tooltip").forEach((e=>{const t=e.getAttribute("data-tooltip");t&&(e.addEventListener("mouseenter",(o=>{const a=document.createElement("div");a.className="athlete-tooltip",a.textContent=t,document.body.appendChild(a);const i=e.getBoundingClientRect();a.style.left=`${i.right+5}px`,a.style.top=i.top+i.height/2-a.offsetHeight/2+"px"})),e.addEventListener("mouseleave",(()=>{document.querySelectorAll(".athlete-tooltip").forEach((e=>e.remove()))})))}))}initializeModals(){document.querySelectorAll(".athlete-dashboard-modal").forEach((e=>{const t=document.createElement("div");t.className="athlete-modal-backdrop",e.before(t);const o=document.createElement("button");o.className="athlete-modal-close",o.innerHTML="×",o.addEventListener("click",(()=>this.closeModal(e))),e.appendChild(o),this.closeModal(e)}))}handleToggle(e){e.preventDefault();const t=document.querySelector(e.target.dataset.target);if(t){const e="none"===t.style.display;t.style.display=e?"block":"none",t.style.height=e?`${t.scrollHeight}px`:"0"}}handleModalTrigger(e){e.preventDefault();const t=e.target.dataset.modal,o=document.getElementById(t);o&&this.openModal(o)}openModal(e){e.style.display="block",e.previousElementSibling?.classList.add("active"),document.body.style.overflow="hidden"}closeModal(e){e.style.display="none",e.previousElementSibling?.classList.remove("active"),document.body.style.overflow=""}static createElement(e,t,o=""){const a=document.createElement(e);return t&&(a.className=t),o&&(a.textContent=o),a}static showLoading(e){const t=a.createElement("div","athlete-loading");return e.appendChild(t),t}static hideLoading(e){e?.remove()}static showError(e,t){const o=a.createElement("div","athlete-error",e);t.appendChild(o),setTimeout((()=>o.remove()),5e3)}}const i=new a;document.addEventListener("DOMContentLoaded",(()=>i.init()))}},t={};function o(a){var i=t[a];if(void 0!==i)return i.exports;var r=t[a]={exports:{}};return e[a](r,r.exports,o),r.exports}o.d=function(e,t){for(var a in t)o.o(t,a)&&!o.o(e,a)&&Object.defineProperty(e,a,{enumerable:!0,get:t[a]})},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)};var a=o(454);const i=new class{constructor(){this.initialized=!1,this.exerciseList=window.athleteDashboard?.exerciseTests||[]}init(){this.initialized||(this.bindEvents(),this.initializeWorkoutForms(),this.initialized=!0)}bindEvents(){document.addEventListener("submit",(e=>{e.target.matches(".workout-form")&&this.handleWorkoutSubmit(e)})),document.addEventListener("click",(e=>{e.target.matches(".log-workout-btn")&&this.handleLogWorkout(e)}))}initializeWorkoutForms(){document.querySelectorAll(".workout-date").forEach((e=>{e.type="date",e.max=(new Date).toISOString().split("T")[0]})),this.initializeExerciseSelectors()}initializeExerciseSelectors(){document.querySelectorAll(".exercise-selector").forEach((e=>{const t=`exercise-list-${Math.random().toString(36).substr(2,9)}`,o=document.createElement("datalist");o.id=t,this.exerciseList.forEach((e=>{const t=document.createElement("option");t.value=e,o.appendChild(t)})),e.setAttribute("list",t),e.after(o)}))}async handleWorkoutSubmit(e){e.preventDefault();const t=e.target,o=new FormData(t),i=t.closest(".workout-container"),r=a.UI.showLoading(i);try{const e=await fetch(window.athleteDashboard.ajax_url,{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:new URLSearchParams({action:"log_workout",nonce:window.athleteDashboard.nonce,workout_data:JSON.stringify(Object.fromEntries(o))})}),a=await e.json();a.success?(this.showMessage("Workout logged successfully!","success",i),t.reset()):this.showMessage(a.data?.message||"Error logging workout. Please try again.","error",i)}catch(e){this.showMessage("Server error. Please try again later.","error",i),console.error("Workout submission error:",e)}finally{a.UI.hideLoading(r)}}async handleLogWorkout(e){e.preventDefault();const t=e.target.dataset.workoutId,o=document.getElementById("workout-form-container");if(!o)return;const i=a.UI.showLoading(o);try{const e=await fetch(window.athleteDashboard.ajax_url,{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:new URLSearchParams({action:"get_workout_form",nonce:window.athleteDashboard.nonce,workout_id:t})}),a=await e.json();a.success?(o.innerHTML=a.data.form,this.initializeWorkoutForms()):this.showMessage(a.data?.message||"Error loading workout form.","error",o)}catch(e){this.showMessage("Server error. Please try again later.","error",o),console.error("Workout form load error:",e)}finally{a.UI.hideLoading(i)}}showMessage(e,t,o){const i=o.querySelector(".workout-message")||a.UI.createElement("div","workout-message");i.className=`workout-message ${t}`,i.textContent=e,i.parentNode||o.insertBefore(i,o.firstChild),setTimeout((()=>{i.classList.add("fade-out"),setTimeout((()=>i.remove()),300)}),3e3)}};document.addEventListener("DOMContentLoaded",(()=>i.init()))}();