// getting the actual date
let today = new Date();
let dayInt = today.getDate();
let month = today.getMonth();
let year = today.getFullYear();
let calendarBody = document.getElementById("days");

let months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
];

function showCalendar(month, year) {

    let firstDay = (new Date(year, month)).getDay();
    calendarBody.innerHTML = "";
    let totalDays = daysInMonth(month, year);

    blankDates(firstDay);

    for (let day = 1; day <= totalDays; day++) {
        let cell = document.createElement("li");
        let cellText = document.createTextNode(day);
        if (dayInt === day &&
            month === today.getMonth() &&
            year === today.getFullYear()) {
            cell.classList.add("active");
        }
        cell.setAttribute("data-day", day);
        cell.setAttribute("data-month", month);
        cell.setAttribute("data-year", year);
        cell.classList.add("singleDay");
        cell.appendChild(cellText);
        calendarBody.appendChild(cell);
    }
    document.getElementById("month").innerHTML = months[month];
    document.getElementById("year").innerHTML = year;
    eventActivator();

}

function daysInMonth(month, year) {
    // day 0 here returns the last day of the PREVIOUS month
    return new Date(year, month + 1, 0).getDate();
}

function blankDates(count) {
    // looping to add the correct amount of blank days to the calendar
    for (let x = 0; x < count; x++) {
        let cell = document.createElement("li");
        let cellText = document.createTextNode("");
        cell.appendChild(cellText);
        calendarBody.appendChild(cell);
    }
}


// next and previous buttons
let nextbtn = document.getElementById("next");
let prevBtn = document.getElementById("prev");

nextbtn.onclick = function () {
    next();
};
prevBtn.onclick = function () {
    previous();
};
//calling/initializing calendar
showCalendar(month, year);

function next() {
    year = month === 11 ? year + 1 : year;
    month = (month + 1) % 12;
    showCalendar(month, year);
}

function previous() {
    year = month === 0 ? year - 1 : year;
    month = month === 0 ? 11 : month - 1;
    showCalendar(month, year);
}


function renderCalendar(year, month) {
    let startOfMonth = new Date(year, month).getDay();
    let numOfDays = 32 - new Date(year, month, 32).getDate();
    let renderNum = 1;

    let renderMonth = document.getElementById('month');
    let renderYear = document.getElementById('year');

    renderMonth.textContent = months['${month}'];
    renderYear.textContent = year;

    let tableBody = document.getElementById('table-body');

    for (i = 0; i < 6; i++) {
        let row = document.createElement('tr');
        for (j = 0; j < 7; c++) {
            if (i === 0 && c < startOfMonth) {
                let td = document.createElement('td');
                td.classList.add('empty');
                row.append(td);
            } else if (render > numOfDays) {
                break;
            } else {
                let td = document.createElement('td');
                td.textContent = renderNum;
                row.append(td);
                renderNum++;
            }
        }
    }
}

function eventActivator() {
    const daysVar=document.querySelectorAll(".singleDay");
    console.log(daysVar);
    daysVar.forEach(item=>{
        item.addEventListener('click',event=>{
            let dataText=event.target.dataset.day;
            let monthText=event.target.dataset.month;
            let yearText=event.target.dataset.year;
            document.getElementById('schedule').innerText="Schedule for " + dataText +" "+ months[month] +' '+yearText;
            console.log(dataText,months[month],yearText);
        })
    })
}


function onClick() {

    alert("Day:  " + this.innerText);
    document.getElementById("days").innerText = `Schedule for July ${this.innerText}, 2022`;
}

// tableData.forEach(function(element) {
//     if(element.textContent === "available") {
//         element.classList.add("available-green");
//     }
// });