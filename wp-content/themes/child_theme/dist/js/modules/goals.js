!function(){"use strict";var e={454:function(e,t,a){a.d(t,{UI:function(){return s}});class o{constructor(){this.initialized=!1}init(){this.initialized||(this.initializeComponents(),this.bindEvents(),this.initialized=!0)}initializeComponents(){this.initializeTabs(),this.initializeTooltips(),this.initializeModals()}bindEvents(){document.addEventListener("click",(e=>{e.target.matches(".athlete-dashboard-toggle")&&this.handleToggle(e),e.target.matches(".athlete-dashboard-modal-trigger")&&this.handleModalTrigger(e)}))}initializeTabs(){document.querySelectorAll(".athlete-dashboard-tabs").forEach((e=>{const t=e.querySelectorAll('[role="tab"]'),a=e.querySelectorAll('[role="tabpanel"]');t.forEach((o=>{o.addEventListener("click",(()=>{t.forEach((e=>e.setAttribute("aria-selected","false"))),a.forEach((e=>e.hidden=!0)),o.setAttribute("aria-selected","true");const s=e.querySelector(`#${o.getAttribute("aria-controls")}`);s&&(s.hidden=!1)}))})),t[0]&&t[0].click()}))}initializeTooltips(){document.querySelectorAll(".athlete-dashboard-tooltip").forEach((e=>{const t=e.getAttribute("data-tooltip");t&&(e.addEventListener("mouseenter",(a=>{const o=document.createElement("div");o.className="athlete-tooltip",o.textContent=t,document.body.appendChild(o);const s=e.getBoundingClientRect();o.style.left=`${s.right+5}px`,o.style.top=s.top+s.height/2-o.offsetHeight/2+"px"})),e.addEventListener("mouseleave",(()=>{document.querySelectorAll(".athlete-tooltip").forEach((e=>e.remove()))})))}))}initializeModals(){document.querySelectorAll(".athlete-dashboard-modal").forEach((e=>{const t=document.createElement("div");t.className="athlete-modal-backdrop",e.before(t);const a=document.createElement("button");a.className="athlete-modal-close",a.innerHTML="×",a.addEventListener("click",(()=>this.closeModal(e))),e.appendChild(a),this.closeModal(e)}))}handleToggle(e){e.preventDefault();const t=document.querySelector(e.target.dataset.target);if(t){const e="none"===t.style.display;t.style.display=e?"block":"none",t.style.height=e?`${t.scrollHeight}px`:"0"}}handleModalTrigger(e){e.preventDefault();const t=e.target.dataset.modal,a=document.getElementById(t);a&&this.openModal(a)}openModal(e){e.style.display="block",e.previousElementSibling?.classList.add("active"),document.body.style.overflow="hidden"}closeModal(e){e.style.display="none",e.previousElementSibling?.classList.remove("active"),document.body.style.overflow=""}static createElement(e,t,a=""){const o=document.createElement(e);return t&&(o.className=t),a&&(o.textContent=a),o}static showLoading(e){const t=o.createElement("div","athlete-loading");return e.appendChild(t),t}static hideLoading(e){e?.remove()}static showError(e,t){const a=o.createElement("div","athlete-error",e);t.appendChild(a),setTimeout((()=>a.remove()),5e3)}}const s=new o;document.addEventListener("DOMContentLoaded",(()=>s.init()))}},t={};function a(o){var s=t[o];if(void 0!==s)return s.exports;var r=t[o]={exports:{}};return e[o](r,r.exports,a),r.exports}a.d=function(e,t){for(var o in t)a.o(t,o)&&!a.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:t[o]})},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)};var o=a(454);const s=new class{constructor(){this.initialized=!1}init(){this.initialized||(this.bindEvents(),this.initializeGoalForms(),this.loadActiveGoals(),this.initialized=!0)}bindEvents(){document.addEventListener("submit",(e=>{e.target.matches(".goal-form")&&this.handleGoalSubmit(e)})),document.addEventListener("click",(e=>{e.target.matches(".update-progress-btn")&&this.handleProgressUpdate(e),e.target.matches(".delete-goal-btn")&&this.handleGoalDelete(e)})),document.addEventListener("input",(e=>{e.target.matches(".progress-range")&&this.updateProgressDisplay(e.target)}))}initializeGoalForms(){document.querySelectorAll(".goal-deadline").forEach((e=>{e.type="date";const t=(new Date).toISOString().split("T")[0];e.min=t})),document.querySelectorAll(".progress-range").forEach((e=>{e.type="range",e.min=0,e.max=100,e.value=e.dataset.progress||0,this.updateProgressDisplay(e)}))}updateProgressDisplay(e){const t=e.nextElementSibling;t&&t.classList.contains("progress-value")&&(t.textContent=`${e.value}%`)}async loadActiveGoals(){const e=document.getElementById("active-goals-container");if(!e)return;const t=o.UI.showLoading(e);try{const t=await fetch(window.athleteDashboard.ajax_url,{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:new URLSearchParams({action:"get_active_goals",nonce:window.athleteDashboard.nonce})}),a=await t.json();a.success?(e.innerHTML=a.data.goals,this.initializeGoalForms()):this.showMessage("Error loading goals. Please try again.","error",e)}catch(t){this.showMessage("Server error. Please try again later.","error",e),console.error("Goals loading error:",t)}finally{o.UI.hideLoading(t)}}async handleGoalSubmit(e){e.preventDefault();const t=e.target,a=new FormData(t),s=t.closest(".goals-container"),r=o.UI.showLoading(s);try{const e=await fetch(window.athleteDashboard.ajax_url,{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:new URLSearchParams({action:"save_goal",nonce:window.athleteDashboard.nonce,goal_data:JSON.stringify(Object.fromEntries(a))})}),o=await e.json();o.success?(this.showMessage("Goal saved successfully!","success",s),await this.loadActiveGoals(),t.reset()):this.showMessage(o.data?.message||"Error saving goal. Please try again.","error",s)}catch(e){this.showMessage("Server error. Please try again later.","error",s),console.error("Goal submission error:",e)}finally{o.UI.hideLoading(r)}}async handleProgressUpdate(e){e.preventDefault();const t=e.target.dataset.goalId,a=e.target.closest(".goal-item"),s=a.querySelector(".progress-range");if(!a||!s)return;const r=o.UI.showLoading(a);try{const e=await fetch(window.athleteDashboard.ajax_url,{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:new URLSearchParams({action:"update_goal_progress",nonce:window.athleteDashboard.nonce,goal_id:t,progress:s.value})}),o=await e.json();o.success?(this.showMessage("Progress updated successfully!","success",a),await this.loadActiveGoals()):this.showMessage(o.data?.message||"Error updating progress. Please try again.","error",a)}catch(e){this.showMessage("Server error. Please try again later.","error",a),console.error("Progress update error:",e)}finally{o.UI.hideLoading(r)}}async handleGoalDelete(e){if(e.preventDefault(),!confirm("Are you sure you want to delete this goal?"))return;const t=e.target.dataset.goalId,a=e.target.closest(".goal-item");if(!a)return;const s=o.UI.showLoading(a);try{const e=await fetch(window.athleteDashboard.ajax_url,{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:new URLSearchParams({action:"delete_goal",nonce:window.athleteDashboard.nonce,goal_id:t})}),o=await e.json();o.success?(this.showMessage("Goal deleted successfully!","success",a),await this.loadActiveGoals()):this.showMessage(o.data?.message||"Error deleting goal. Please try again.","error",a)}catch(e){this.showMessage("Server error. Please try again later.","error",a),console.error("Goal deletion error:",e)}finally{o.UI.hideLoading(s)}}showMessage(e,t,a){const s=a.querySelector(".goals-message")||o.UI.createElement("div","goals-message");s.className=`goals-message ${t}`,s.textContent=e,s.parentNode||a.insertBefore(s,a.firstChild),setTimeout((()=>{s.classList.add("fade-out"),setTimeout((()=>s.remove()),300)}),3e3)}};document.addEventListener("DOMContentLoaded",(()=>s.init()))}();