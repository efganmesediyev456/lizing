const languageData = {
  months: [
          "Yanvar", "Fevral", "Mart", "Aprel", "May", "Iyun",
          "Iyul", "Avqust", "Sentyabr", "Oktyabr", "Noyabr", "Dekabr"
  ],
  daysOfWeek: ['B.e', 'Ç.a', 'Ç', 'C.a', 'C', 'Ş', 'B'],
};

let currentDate = new Date();


// Haftanın gün adlarını yükleme
function loadDaysOfWeek() {
  const calendarDaysContainer = document.querySelector('.calendar-days');
  if (!calendarDaysContainer) return; // Eğer eleman yoksa çık

  const daysOfWeek = languageData.daysOfWeek;
  calendarDaysContainer.innerHTML = ''; // Mevcut günleri temizle
  daysOfWeek.forEach(day => {
      const dayElem = document.createElement('div');
      dayElem.classList.add('calendar-day-item');
      dayElem.textContent = day;
      calendarDaysContainer.appendChild(dayElem);
  });
}

// Takvimi yükleme fonksiyonu
function loadCalendar(month, year) {
  const calendarGrid = document.querySelector(".calendar-grid");
  if (!calendarGrid) return; // Eğer eleman yoksa çık

  const months = languageData.months;
  calendarGrid.innerHTML = ""; // Önceki günleri temizle

  // Mevcut ay ve yıl başlığı
  const monthElement = document.querySelector(".calendar-month-year .calendar-month");
  if (monthElement) {
      monthElement.textContent = `${months[month]}`;
  }
  const yearElement = document.querySelector(".calendar-month-year .calendar-year");
  if (yearElement) {
      yearElement.textContent = `${year}`;
  }

  // Ayın ilk günü ve toplam gün sayısı
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  // Bir önceki ayın günleri
  const daysInPrevMonth = new Date(year, month, 0).getDate();
  const prevDaysCount = firstDay === 0 ? 6 : firstDay - 1;

  // Önceki ayın günlerini ekleme
  for (let i = prevDaysCount; i > 0; i--) {
      const prevDayElem = document.createElement("div");
      prevDayElem.classList.add("prev-month");
      prevDayElem.textContent = daysInPrevMonth - i + 1;
      calendarGrid.appendChild(prevDayElem);
  }

  // Geçerli ayın günlerini ekleme
for (let i = 1; i <= daysInMonth; i++) {
    const dayElem = document.createElement("div");
    dayElem.classList.add("current-month"); // Geçerli ay günlerine class ekleniyor
    const currentDateString = `${year}-${(month + 1).toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;
    dayElem.textContent = i;

    const currentDayDate = new Date(currentDateString);

    // 🟢 Bugünün tarihine 'active' class'ı ekle
    const today = new Date();
    if (
        currentDayDate.getFullYear() === today.getFullYear() &&
        currentDayDate.getMonth() === today.getMonth() &&
        currentDayDate.getDate() === today.getDate()
    ) {
        dayElem.classList.add("active");
    }

    calendarGrid.appendChild(dayElem);
}

  // Bir sonraki ayın günlerini ekleme
  const totalGridItems = prevDaysCount + daysInMonth;
  const nextDaysCount = totalGridItems % 7 === 0 ? 0 : 7 - (totalGridItems % 7);

  for (let i = 1; i <= nextDaysCount; i++) {
      const nextDayElem = document.createElement("div");
      nextDayElem.classList.add("next-month");
      nextDayElem.textContent = i;
      calendarGrid.appendChild(nextDayElem);
  }
}

// Haftanın gün adlarını ve takvimi yüklüyoruz
if (document.querySelector('.calendar-days')) {
  loadDaysOfWeek();
}
if (document.querySelector('.calendar-grid')) {
  loadCalendar(currentDate.getMonth(), currentDate.getFullYear());
}

// Ay değiştirme butonları
const prevButton = document.querySelector(".prev-month");
const nextButton = document.querySelector(".next-month");
if (prevButton) {
  prevButton.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    loadCalendar(currentDate.getMonth(), currentDate.getFullYear());
  });
}

if (nextButton) {
  nextButton.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    loadCalendar(currentDate.getMonth(), currentDate.getFullYear());
  });
}


const notification_btn=document.querySelector(".notification-btn")
notification_btn?.addEventListener("click", () => {
    const parent = notification_btn.parentElement;
    parent.classList.toggle("active");
});
document.addEventListener("click", (e) => {
    const parent_notification_btn = notification_btn.parentElement;
    if (!parent_notification_btn.contains(e.target)) {
      parent_notification_btn.classList.remove("active");
    }
});

const header_user_btn=document.querySelector(".header-user-btn")
header_user_btn?.addEventListener("click", () => {
    const parent = header_user_btn.parentElement;
    parent.classList.toggle("active");
});
document.addEventListener("click", (e) => {
    const parent_header_user = header_user_btn.parentElement;
    if (!parent_header_user.contains(e.target)) {
      parent_header_user.classList.remove("active");
    }
});

const actionBtns = document.querySelectorAll(".actionBtn");

actionBtns.forEach(actionBtn => {
  actionBtn?.addEventListener("click", () => {
    const next = actionBtn.nextElementSibling;
    next.classList.toggle("active");
  });
});

document.addEventListener("click", (e) => {
  actionBtns.forEach(actionBtn => {
    const actionBtn_next = actionBtn.nextElementSibling;
    if (!actionBtn.contains(e.target) && !actionBtn_next.contains(e.target)) {
      actionBtn_next.classList.remove("active");
    }
  });
});

document.body.addEventListener("click", function (e) {
  if (e.target.classList.contains("actionBtn")) {
    const next = e.target.nextElementSibling;
    if (next) {
      next.classList.toggle("active");
    }
  }
});


document.addEventListener("click", function (e) {
  document.querySelectorAll(".actionBtn").forEach(actionBtn => {
    const next = actionBtn.nextElementSibling;
    if (!actionBtn.contains(e.target) && !next.contains(e.target)) {
      next.classList.remove("active");
    }
  });
});




const closeError=document.querySelector(".closeError")
closeError?.addEventListener("click",()=>{
  closeError.parentElement.parentElement.style.display="none"
})
const closeSuccess=document.querySelector(".closeSuccess")
closeSuccess?.addEventListener("click",()=>{
  closeSuccess.parentElement.parentElement.style.display="none"
})



const crm_container = document.querySelector(".crm-container");
const aside_resize_btn = document.querySelector(".aside_resize_btn");
const crm_body = document.querySelector(".crm-body");
const menuLinks = document.querySelectorAll(".menuLink");
const aside_dropdowns = document.querySelectorAll(".aside-dropdown");
const exitProfile = document.querySelector(".exitProfile");
const asideDownBtns = document.querySelectorAll(".asideDownBtn");

const mouseEnter = () => {
  crm_body.classList.add("darkness");
};

const mouseLeave = () => {
  crm_body.classList.remove("darkness");
};

const addHoverEvents = () => {
  menuLinks.forEach(menuLink => {
    menuLink?.addEventListener("mouseenter", mouseEnter);
    menuLink?.addEventListener("mouseleave", mouseLeave);
  });
  aside_dropdowns.forEach(asideDropdown => {
    asideDropdown?.addEventListener("mouseenter", mouseEnter);
    asideDropdown?.addEventListener("mouseleave", mouseLeave);
  });
  exitProfile?.addEventListener("mouseenter", mouseEnter);
  exitProfile?.addEventListener("mouseleave", mouseLeave);
};

const removeHoverEvents = () => {
  menuLinks.forEach(menuLink => {
    menuLink?.removeEventListener("mouseenter", mouseEnter);
    menuLink?.removeEventListener("mouseleave", mouseLeave);
  });
  aside_dropdowns.forEach(asideDropdown => {
    asideDropdown?.removeEventListener("mouseenter", mouseEnter);
    asideDropdown?.removeEventListener("mouseleave", mouseLeave);
  });
  exitProfile?.removeEventListener("mouseenter", mouseEnter);
  exitProfile?.removeEventListener("mouseleave", mouseLeave);
};

const handleResponsiveHover = () => {
  const isLargeScreen = window.innerWidth > 992;
  const isShortAside = crm_container?.classList.contains("short-aside");

  if (isLargeScreen && isShortAside) {
    addHoverEvents();
  } else {
    removeHoverEvents();
  }
};

handleResponsiveHover();
window.addEventListener("resize", handleResponsiveHover);

aside_resize_btn?.addEventListener("click", () => {
  crm_container.classList.toggle("short-aside");
  handleResponsiveHover();
});

asideDownBtns.forEach(asideDownBtn => {
  asideDownBtn?.addEventListener("click", () => {
    const isLargeScreen = window.innerWidth > 992;
    const isShortAside = crm_container?.classList.contains("short-aside");

    if (!(isLargeScreen && isShortAside)) {
      const parent = asideDownBtn.parentElement;
      parent.classList.toggle("active");
    }
  });
});

document.addEventListener("click", (e) => {
  asideDownBtns.forEach(asideDownBtn => {
    const isLargeScreen = window.innerWidth > 992;
    const isShortAside = crm_container?.classList.contains("short-aside");

    if (!(isLargeScreen && isShortAside)) {
      const parent = asideDownBtn.parentElement;
      if (!parent.contains(e.target)) {
        parent.classList.remove("active");
      }
    }
  });
});

const closeAside=document.querySelector(".closeAside")
closeAside?.addEventListener("click",()=>{
  crm_container.classList.remove("short-aside")
})



const password_eyes=document.querySelectorAll(".password-eye")
password_eyes.forEach(password_eye=>{
  password_eye?.addEventListener("click",()=>{
    const prevInput=password_eye.previousElementSibling
    if(prevInput.type==="password"){
      prevInput.type="text"
      password_eye.classList.add("showed")
    }else{
      prevInput.type="password"
      password_eye.classList.remove("showed")
    }
  })
})


//========================Payment Modals====================================

const add_driver_container = document.querySelector(".add-driver-container");
const closeAddDriver = document.querySelector(".closeAddDriver");
const addNewDriver = document.querySelector(".addNewDriver");

addNewDriver?.addEventListener("click", () => {
  add_driver_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddDriver?.addEventListener("click", () => {
  add_driver_container.style.display = "none";
  document.body.style.overflow = "auto";
});

const edit_driver_container = document.querySelector(".edit-driver-container");
const closeEditDriver = document.querySelector(".closeEditDriver");
const editDriverBtns = document.querySelectorAll(".editDriverBtn");


editDriverBtns.forEach(editDriverBtn=>{
  editDriverBtn?.addEventListener("click", () => {
    edit_driver_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditDriver?.addEventListener("click", () => {
  edit_driver_container.style.display = "none";
  document.body.style.overflow = "auto";
});

const send_notification_container = document.querySelector(".send-notification-container");
const closeSendNotification = document.querySelector(".closeSendNotification");
const notificationDriverBtns = document.querySelectorAll(".notificationDriverBtn");

notificationDriverBtns.forEach(notificationDriverBtn=>{
  notificationDriverBtn?.addEventListener("click", () => {
    send_notification_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})
closeSendNotification?.addEventListener("click", () => {
  send_notification_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const payment_driver_container = document.querySelector(".payment-driver-container");
const closePaymentDriver = document.querySelector(".closePaymentDriver");
const paymentDriverBtns = document.querySelectorAll(".paymentDriverBtn");

paymentDriverBtns.forEach(paymentDriverBtn=>{
  paymentDriverBtn?.addEventListener("click", () => {
    payment_driver_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})
closePaymentDriver?.addEventListener("click", () => {
  payment_driver_container.style.display = "none";
  document.body.style.overflow = "auto";
});



//========================Ban Type Modals====================================
const add_banType_container = document.querySelector(".add-banType-container");
const closeAddBanType = document.querySelector(".closeAddBanType");
const addNewBanType = document.querySelector(".addNewBanType");

addNewBanType?.addEventListener("click", () => {
  add_banType_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddBanType?.addEventListener("click", () => {
  add_banType_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_banType_container = document.querySelector(".edit-banType-container");
const closeEditBanType = document.querySelector(".closeEditBanType");
const editBanTypeBtns = document.querySelectorAll(".editBanTypeBtn");


editBanTypeBtns.forEach(editBanTypeBtn=>{
  editBanTypeBtn?.addEventListener("click", () => {
    edit_banType_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditBanType?.addEventListener("click", () => {
  edit_banType_container.style.display = "none";
  document.body.style.overflow = "auto";
});



//========================Auto Modals====================================
const add_auto_container = document.querySelector(".add-auto-container");
const closeAddAuto = document.querySelector(".closeAddAuto");
const addNewAuto = document.querySelector(".addNewAuto");

addNewAuto?.addEventListener("click", () => {
  add_auto_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddAuto?.addEventListener("click", () => {
  add_auto_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_auto_container = document.querySelector(".edit-auto-container");
const closeEditAuto = document.querySelector(".closeEditAuto");
const editAutoBtns = document.querySelectorAll(".editAutoBtn");


editAutoBtns.forEach(editAutoBtn=>{
  editAutoBtn?.addEventListener("click", () => {
    edit_auto_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditAuto?.addEventListener("click", () => {
  edit_auto_container.style.display = "none";
  document.body.style.overflow = "auto";
});



//========================Credit Modals====================================
const add_credit_container = document.querySelector(".add-credit-container");
const closeAddCredit = document.querySelector(".closeAddCredit");
const addNewCredit = document.querySelector(".addNewCredit");

addNewCredit?.addEventListener("click", () => {
  add_credit_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddCredit?.addEventListener("click", () => {
  add_credit_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_credit_container = document.querySelector(".edit-credit-container");
const closeEditCredit = document.querySelector(".closeEditCredit");
const editCreditBtns = document.querySelectorAll(".editCreditBtn");


editCreditBtns.forEach(editCreditBtn=>{
  editCreditBtn?.addEventListener("click", () => {
    edit_credit_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditCredit?.addEventListener("click", () => {
  edit_credit_container.style.display = "none";
  document.body.style.overflow = "auto";
});


//========================Brand Modals====================================
const add_brand_container = document.querySelector(".add-brand-container");
const closeAddBrand = document.querySelector(".closeAddBrand");
const addNewBrand = document.querySelector(".addNewBrand");

addNewBrand?.addEventListener("click", () => {
  add_brand_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddBrand?.addEventListener("click", () => {
  add_brand_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_brand_container = document.querySelector(".edit-brand-container");
const closeEditBrand = document.querySelector(".closeEditBrand");
const editBrandBtns = document.querySelectorAll(".editBrandBtn");


editBrandBtns.forEach(editBrandBtn=>{
  editBrandBtn?.addEventListener("click", () => {
    edit_brand_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditBrand?.addEventListener("click", () => {
  edit_brand_container.style.display = "none";
  document.body.style.overflow = "auto";
});


//========================Model Modals====================================
const add_model_container = document.querySelector(".add-model-container");
const closeAddModel = document.querySelector(".closeAddModel");
const addNewModel = document.querySelector(".addNewModel");

addNewModel?.addEventListener("click", () => {
  add_model_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddModel?.addEventListener("click", () => {
  add_model_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_model_container = document.querySelector(".edit-model-container");
const closeEditModel = document.querySelector(".closeEditModel");
const editModelBtns = document.querySelectorAll(".editModelBtn");


editModelBtns.forEach(editModelBtn=>{
  editModelBtn?.addEventListener("click", () => {
    edit_model_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditModel?.addEventListener("click", () => {
  edit_model_container.style.display = "none";
  document.body.style.overflow = "auto";
});


//========================Insurance Modals====================================
const add_insurance_container = document.querySelector(".add-insurance-container");
const closeAddInsurance = document.querySelector(".closeAddInsurance");
const addNewInsurance = document.querySelector(".addNewInsurance");

addNewInsurance?.addEventListener("click", () => {
  add_insurance_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddInsurance?.addEventListener("click", () => {
  add_insurance_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_insurance_container = document.querySelector(".edit-insurance-container");
const closeEditInsurance = document.querySelector(".closeEditInsurance");
const editInsuranceBtns = document.querySelectorAll(".editInsuranceBtn");


editInsuranceBtns.forEach(editInsuranceBtn=>{
  editInsuranceBtn?.addEventListener("click", () => {
    edit_insurance_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditInsurance?.addEventListener("click", () => {
  edit_insurance_container.style.display = "none";
  document.body.style.overflow = "auto";
});

const payment_insurance_container = document.querySelector(".payment-insurance-container");
const closePaymentInsurance = document.querySelector(".closePaymentInsurance");
const payInsuranceBtns = document.querySelectorAll(".payInsuranceBtn");

payInsuranceBtns.forEach(payInsuranceBtn=>{
  payInsuranceBtn?.addEventListener("click", () => {
    payment_insurance_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})
closePaymentInsurance?.addEventListener("click", () => {
  payment_insurance_container.style.display = "none";
  document.body.style.overflow = "auto";
});



//========================Technical Modals====================================
const add_technical_container = document.querySelector(".add-technical-container");
const closeAddTechnical = document.querySelector(".closeAddTechnical");
const addNewTechnical = document.querySelector(".addNewTechnical");

addNewTechnical?.addEventListener("click", () => {
  add_technical_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddTechnical?.addEventListener("click", () => {
  add_technical_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_technical_container = document.querySelector(".edit-technical-container");
const closeEditTechnical = document.querySelector(".closeEditTechnical");
const editTechnicalBtns = document.querySelectorAll(".editTechnicalBtn");


editTechnicalBtns.forEach(editTechnicalBtn=>{
  editTechnicalBtn?.addEventListener("click", () => {
    edit_technical_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditTechnical?.addEventListener("click", () => {
  edit_technical_container.style.display = "none";
  document.body.style.overflow = "auto";
});

const payment_technical_container = document.querySelector(".payment-technical-container");
const closePaymentTechnical = document.querySelector(".closePaymentTechnical");
const payTechnicalBtns = document.querySelectorAll(".payTechnicalBtn");

payTechnicalBtns.forEach(payTechnicalBtn=>{
  payTechnicalBtn?.addEventListener("click", () => {
    payment_technical_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})
closePaymentTechnical?.addEventListener("click", () => {
  payment_technical_container.style.display = "none";
  document.body.style.overflow = "auto";
});


//========================Oil Change Modals====================================
const add_oilChange_container = document.querySelector(".add-oilChange-container");
const closeAddOilChange = document.querySelector(".closeAddOilChange");
const addNewOilChange = document.querySelector(".addNewOilChange");

addNewOilChange?.addEventListener("click", () => {
  add_oilChange_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddOilChange?.addEventListener("click", () => {
  add_oilChange_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_oilChange_container = document.querySelector(".edit-oilChange-container");
const closeEditOilChange = document.querySelector(".closeEditOilChange");
const editOilChangeBtns = document.querySelectorAll(".editOilChangeBtn");


editOilChangeBtns.forEach(editOilChangeBtn=>{
  editOilChangeBtn?.addEventListener("click", () => {
    edit_oilChange_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditOilChange?.addEventListener("click", () => {
  edit_oilChange_container.style.display = "none";
  document.body.style.overflow = "auto";
});

//========================Penalty Modals====================================
const add_penalty_container = document.querySelector(".add-penalty-container");
const closeAddPenalty = document.querySelector(".closeAddPenalty");
const addNewPenalty = document.querySelector(".addNewPenalty");

addNewPenalty?.addEventListener("click", () => {
  add_penalty_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddPenalty?.addEventListener("click", () => {
  add_penalty_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_penalty_container = document.querySelector(".edit-penalty-container");
const closeEditPenalty = document.querySelector(".closeEditPenalty");
const editPenaltyBtns = document.querySelectorAll(".editPenaltyBtn");


editPenaltyBtns.forEach(editPenaltyBtn=>{
  editPenaltyBtn?.addEventListener("click", () => {
    edit_penalty_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditPenalty?.addEventListener("click", () => {
  edit_penalty_container.style.display = "none";
  document.body.style.overflow = "auto";
});

const payment_penalty_container = document.querySelector(".payment-penalty-container");
const closePaymentPenalty = document.querySelector(".closePaymentPenalty");
const payPenaltyBtns = document.querySelectorAll(".payPenaltyBtn");

payPenaltyBtns.forEach(payPenaltyBtn=>{
  payPenaltyBtn?.addEventListener("click", () => {
    payment_penalty_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})
closePaymentPenalty?.addEventListener("click", () => {
  payment_penalty_container.style.display = "none";
  document.body.style.overflow = "auto";
});

//========================Leasing Modals====================================
const add_leasing_container = document.querySelector(".add-leasing-container");
const closeAddLeasing = document.querySelector(".closeAddLeasing");
const addNewLeasing = document.querySelector(".addNewLeasing");

addNewLeasing?.addEventListener("click", () => {
  add_leasing_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddLeasing?.addEventListener("click", () => {
  add_leasing_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_leasing_container = document.querySelector(".edit-leasing-container");
const closeEditLeasing = document.querySelector(".closeEditLeasing");
const editLeasingBtns = document.querySelectorAll(".editLeasingBtn");


editLeasingBtns.forEach(editLeasingBtn=>{
  editLeasingBtn?.addEventListener("click", () => {
    edit_leasing_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditLeasing?.addEventListener("click", () => {
  edit_leasing_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const leasing_tabs=document.querySelectorAll(".leasing_tab")
const viewLeasing_contents=document.querySelectorAll(".viewLeasing_content")

leasing_tabs.forEach(leasing_tab=>{
  leasing_tab?.addEventListener("click",()=>{
    leasing_tabs.forEach(l=>l.classList.remove("active"))
    viewLeasing_contents.forEach(vl=>vl.classList.remove("active"))
    leasing_tab.classList.add("active")
    let id=leasing_tab.id
    document.querySelector(`.viewLeasing_content[data-id=${id}]`).classList.add("active")
  })
})



//========================Deposits Modals====================================
const add_deposits_container = document.querySelector(".add-deposits-container");
const closeAddDeposits = document.querySelector(".closeAddDeposits");
const addNewDeposits = document.querySelector(".addNewDeposits");

addNewDeposits?.addEventListener("click", () => {
  add_deposits_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddDeposits?.addEventListener("click", () => {
  add_deposits_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_deposits_container = document.querySelector(".edit-deposits-container");
const closeEditDeposits = document.querySelector(".closeEditDeposits");
const editDepositBtns = document.querySelectorAll(".editDepositBtn");


editDepositBtns.forEach(editDepositBtn=>{
  editDepositBtn?.addEventListener("click", () => {
    edit_deposits_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditDeposits?.addEventListener("click", () => {
  edit_deposits_container.style.display = "none";
  document.body.style.overflow = "auto";
});


//========================Expenses Modals====================================
const add_expenses_container = document.querySelector(".add-expenses-container");
const closeAddExpenses = document.querySelector(".closeAddExpenses");
const addNewExpenses = document.querySelector(".addNewExpenses");

addNewExpenses?.addEventListener("click", () => {
  add_expenses_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddExpenses?.addEventListener("click", () => {
  add_expenses_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_expenses_container = document.querySelector(".edit-expenses-container");
const closeEditExpenses = document.querySelector(".closeEditExpenses");
const editExpensesBtns = document.querySelectorAll(".editExpensesBtn");


editExpensesBtns.forEach(editExpensesBtn=>{
  editExpensesBtn?.addEventListener("click", () => {
    edit_expenses_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditExpenses?.addEventListener("click", () => {
  edit_expenses_container.style.display = "none";
  document.body.style.overflow = "auto";
});


//========================Revenue Modals====================================
const add_revenue_container = document.querySelector(".add-revenue-container");
const closeAddRevenue = document.querySelector(".closeAddRevenue");
const addNewRevenue = document.querySelector(".addNewRevenue");

addNewRevenue?.addEventListener("click", () => {
  add_revenue_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddRevenue?.addEventListener("click", () => {
  add_revenue_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_revenue_container = document.querySelector(".edit-revenue-container");
const closeEditRevenue = document.querySelector(".closeEditRevenue");
const editRevenueBtns = document.querySelectorAll(".editRevenueBtn");


editRevenueBtns.forEach(editRevenueBtn=>{
  editRevenueBtn?.addEventListener("click", () => {
    edit_revenue_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditRevenue?.addEventListener("click", () => {
  edit_revenue_container.style.display = "none";
  document.body.style.overflow = "auto";
});




//========================debt Modals====================================
const add_debt_container = document.querySelector(".add-debt-container");
const closeAddDebt = document.querySelector(".closeAddDebt");
const addNewDebt = document.querySelector(".addNewDebt");

addNewDebt?.addEventListener("click", () => {
  add_debt_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddDebt?.addEventListener("click", () => {
  add_debt_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_debt_container = document.querySelector(".edit-debt-container");
const closeEditDebt = document.querySelector(".closeEditDebt");
const editDebtBtns = document.querySelectorAll(".editDebtBtn");


editDebtBtns.forEach(editDebtBtn=>{
  editDebtBtn?.addEventListener("click", () => {
    edit_debt_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditDebt?.addEventListener("click", () => {
  edit_debt_container.style.display = "none";
  document.body.style.overflow = "auto";
});




//========================CashBox Modals====================================
const add_cashbox_container = document.querySelector(".add-cashbox-container");
const closeAddCashbox = document.querySelector(".closeAddCashbox");
const addNewCashbox = document.querySelector(".addNewCashbox");

addNewCashbox?.addEventListener("click", () => {
  add_cashbox_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddCashbox?.addEventListener("click", () => {
  add_cashbox_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_cashbox_container = document.querySelector(".edit-cashbox-container");
const closeEditCashbox = document.querySelector(".closeEditCashbox");
const editCashboxBtns = document.querySelectorAll(".editCashboxBtn");


editCashboxBtns.forEach(editCashboxBtn=>{
  editCashboxBtn?.addEventListener("click", () => {
    edit_cashbox_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditCashbox?.addEventListener("click", () => {
  edit_cashbox_container.style.display = "none";
  document.body.style.overflow = "auto";
});

//========================User Modals====================================
const add_user_container = document.querySelector(".add-user-container");
const closeAddUser = document.querySelector(".closeAddUser");
const addNewUsers = document.querySelector(".addNewUsers");

addNewUsers?.addEventListener("click", () => {
  add_user_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddUser?.addEventListener("click", () => {
  add_user_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_user_container = document.querySelector(".edit-user-container");
const closeEditUser = document.querySelector(".closeEditUser");
const editUserBtns = document.querySelectorAll(".editUserBtn");


document.body.addEventListener('click', function(event) {
  if (event.target.classList.contains('editUserBtn')) {
    add_user_container.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }
});


closeEditUser?.addEventListener("click", () => {
  edit_user_container.style.display = "none";
  document.body.style.overflow = "auto";
});


//========================Role Management Modals====================================
const add_roleManagement_container = document.querySelector(".add-roleManagement-container");
const closeAddRoleManagement = document.querySelector(".closeAddRoleManagement");
const addNewRoleManagement = document.querySelector(".addNewRoleManagement");

addNewRoleManagement?.addEventListener("click", () => {
  add_roleManagement_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddRoleManagement?.addEventListener("click", () => {
  add_roleManagement_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_roleManagement_container = document.querySelector(".edit-roleManagement-container");
const closeEditRoleManagement = document.querySelector(".closeEditRoleManagement");
const editRoleBtns = document.querySelectorAll(".editRoleBtn");


editRoleBtns.forEach(editRoleBtn=>{
  editRoleBtn?.addEventListener("click", () => {
    edit_roleManagement_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditRoleManagement?.addEventListener("click", () => {
  edit_roleManagement_container.style.display = "none";
  document.body.style.overflow = "auto";
});


//========================Oil Change Modals====================================
const add_oilChangeType_container = document.querySelector(".add-oilChangeType-container");
const closeAddOilChangeType = document.querySelector(".closeAddOilChangeType");
const addNewOilChangeType = document.querySelector(".addNewOilChangeType");

addNewOilChangeType?.addEventListener("click", () => {
  add_oilChangeType_container.style.display = "flex";
  document.body.style.overflow = "hidden";
});

closeAddOilChangeType?.addEventListener("click", () => {
  add_oilChangeType_container.style.display = "none";
  document.body.style.overflow = "auto";
});


const edit_oilChangeType_container = document.querySelector(".edit-oilChangeType-container");
const closeEditOilChangeType = document.querySelector(".closeEditOilChangeType");
const editOilChangeTypeBtns = document.querySelectorAll(".editOilChangeTypeBtn");


editOilChangeTypeBtns.forEach(editOilChangeTypeBtn=>{
  editOilChangeTypeBtn?.addEventListener("click", () => {
    edit_oilChangeType_container.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
})

closeEditOilChangeType?.addEventListener("click", () => {
  edit_oilChangeType_container.style.display = "none";
  document.body.style.overflow = "auto";
});