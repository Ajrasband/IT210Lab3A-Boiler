function updateLocal(newData) {
    return localStorage.setItem("Data", JSON.stringify(newData));
}

function updateSort(newData) {
    return localStorage.setItem("Sort Data", JSON.stringify(newData));
}

function getLocal() {
    var datatable = localStorage.getItem("Data");
    return datatable;
}

function getSorted() {
    var dataTable = localStorage.getItem("Sort Data");
    return dataTable;
}

function compare(a, b) {
    var dateA = a.duedate
    var dateB = b.duedate
    let comparison = 0;
    if (dateA > dateB) {
        comparison = 1;
    } else if (dateA < dateB) {
        comparison = -1;
    }
    return comparison;
}

function createSortBtn(bool) {
    if (bool === 'true') {
        var btn = document.getElementById("sort_button");
        btn.classList.add("disabled");
    } else if (bool === 'false') {
        var btn = document.getElementById("unsort_button");
        btn.classList.add("disabled");
    }
}

function completeItem(dataTable, taskID) {
    // Deletes item from data, saves it to localStorage
    if (dataTable[taskID].completedStatus === "Yes") {
        dataTable[taskID].completedStatus = "No";
    } else {
        dataTable[taskID].completedStatus = "Yes";
    }
    updateLocal(dataTable);
    return dataTable;
}

function clearTable(dataTable) {
    dataTable.length = 0;
    updateLocal(dataTable);
    return dataTable;
}

function createItem(dataTable) {
    // Pulls in form data from DOM, formats it to JSON, and saves it to localStorage
    var name = document.getElementById("task_name").value
    var date = document.getElementById("duedate").value
    name = escape(name);
    name = decodeURI(name);
    dataTable.push({
        task_name: name,
        duedate: date,
        completedStatus: "No"
    })
    updateLocal(dataTable);
    updateItem(dataTable);
    return;
}

function readItems(dataTable) {
    for (var i = 0; i < dataTable.length; i++) {
        if (dataTable[i].completedStatus === "Del") {
            //Do nothing, we don't want it to be seen.
        } else if (dataTable[i].completedStatus === "Yes") {
            const markup = `
            <li class="list-group-item">
            <label>
            <input id = "complete" value = "${i}" type="checkbox" class="filled-in" checked="checked"/>
            <span>Complete</span>
            </label>
            <span id="task_done"><s>${dataTable[i].task_name}</s></span>
            <span id="task_done"><s>${dataTable[i].duedate}</s></span>
            <span id="delete-button" value = "${i}"><a class="waves-effect waves-light btn-small"><i class="material-icons right">clear</i>Delete</a></span>
            </li>
            `;
            var list = document.getElementById("myList");
            var newTask = document.createElement("li");
            newTask.innerHTML = markup;
            list.appendChild(newTask);
        } else {
            const markup = `
            <li class="list-group-item">
            <label>
            <input id = "complete" value = "${i}" type="checkbox" class="filled-in"/>
            <span>Complete</span>
            </label>
            <span>${dataTable[i].task_name}</span>
            <span>${dataTable[i].duedate}</span>
            <span id="delete-button" value = "${i}"><a class="waves-effect waves-light btn-small"><i class="material-icons right">clear</i>Delete</a></span>
            </li>
            `;
            var list = document.getElementById("myList");
            var newTask = document.createElement("li");
            newTask.innerHTML = markup;
            list.appendChild(newTask);
        }
    }
}

function updateItem(dataTable) {
    const markup = `
    <li>
    <label>
    <input id = "complete" value = "${dataTable.length - 1}" type="checkbox" class="filled-in"/>
    <span>Complete</span>
    </label>
    <span>${dataTable[dataTable.length - 1].task_name}</span>
    <span>${dataTable[dataTable.length - 1].duedate}</span>
    <span id="delete-button" value = "${dataTable.length - 1}"><a class="waves-effect waves-light btn-small"><i class="material-icons right">clear</i>Delete</a></span>
    </li>
    `
    var list = document.getElementById("myList");
    var newTask = document.createElement("li");
    newTask.innerHTML = markup;
    list.appendChild(newTask);
}

function deleteItem(dataTable, taskID) {
    // Deletes item from data, saves it to localStorage
    dataTable[taskID].completedStatus = "Del";
    updateLocal(dataTable);
    if (dataTable.length === 1 && dataTable[0].completedStatus === "Del") {
        dataTable = clearTable(data);
    }
    for (var i = 0; i < dataTable.length; i++) {
        if (dataTable[i].completedStatus === "Del") {
            dataTable.splice(i, 1);
        }
    }
    updateLocal(data);
    return dataTable;
}
var bool = localStorage.getItem("SortBool") || 'false';
var sorted = bool;
localStorage.setItem("SortBool", sorted);
createSortBtn(sorted);
var isSort = getSorted();
var sort = JSON.parse(isSort) || [];
updateSort(sort);
var dataResults = getLocal();
var data = JSON.parse(dataResults) || [];
var stateName = localStorage.getItem("task_name") || '';
localStorage.setItem("task_name", stateName);
document.getElementById("task_name").value = stateName;
var stateDate = localStorage.getItem("duedate") || '';
localStorage.setItem("duedate", stateDate);
document.getElementById("duedate").value = stateDate;
updateLocal(data);
readItems(data);

var button = document.getElementById("button");
button.addEventListener("click", function (event) {
    createItem(data);
    localStorage.removeItem('duedate');
    localStorage.removeItem('task_name');
    location.reload();
});

document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems);
});

var complete = document.querySelectorAll("#complete");
for (var i = 0; i < complete.length; i++) {
    complete[i].addEventListener("click", function (event) {
        var taskID = this.value;
        completeItem(data, taskID);
        location.reload();
    });
}

var complete = document.querySelectorAll("#delete-button");
for (var i = 0; i < complete.length; i++) {
    complete[i].addEventListener("click", function (event) {
        var id = this.getAttribute("value");
        data = deleteItem(data, id);
        location.reload();
    });
}

var button = document.getElementById("sort_button");
button.addEventListener("click", function (event) {
    localStorage.setItem("SortBool", 'true');
    sort = [...data];
    sort.sort(compare);
    updateSort(sort);
    var oldData = data;
    localStorage.setItem("Old Data", JSON.stringify(oldData));
    data = sort;
    updateLocal(data);
    location.reload();
});

var button = document.getElementById("unsort_button");
button.addEventListener("click", function (event) {
    localStorage.setItem("SortBool", false);
    var oldData = localStorage.getItem("Old Data");
    data = JSON.parse(oldData) || [];
    updateLocal(data);
    location.reload();
});