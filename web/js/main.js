$(".addLocation").on("click", function () {
    let location_id = $(this).parent().find("[name=custom-attribute-dropdown]").val()
    let selected_element = $(this).parent().find("select option:selected")
    let location_name = selected_element.text()
    selected_element.remove()
    let person_id = $(this).attr("person_id")
    console.log(location_id)
    console.log(person_id)

    let id = person_id + "_" + location_id
    if (location_id != 0) {
        let html = createJobAssignToLocation(id, location_name)
        $(this).parent().parent().append(html)
    }
})

function createJobAssignToLocation(id, location_name) {
    let html = '<div class="specific_location">'
        + '<div class="location_name">'
        + ' <span>' + location_name + '</span>'
        + '</div>'
        + ' <div ondrop="drop(event,\'' + id + '\')" ondragover="allowDrop(event)" job_status="unassigned" class="job_assign">';

    work_items.forEach(function (a) {
        html += '<span id=\"job_' + a.id + '_' + id + '\" from=\"' + id + '\" draggable=\"true\" ondragstart=\"drag(event)\">' + a.name + '</span>';
    })

    html += '</div>'
        + '<div ondrop="drop(event,\'' + id + '\')" ondragover="allowDrop(event)"  job_status="assigned" class="job_assign"></div>'
        + '</div>'
    return html;
}
$("#saveAllInformation").on("click", function () {
    let assigned_jobs = []

    $("[job_status=assigned]").find("span").each(function () {
        let split = $(this).attr("id").split("_")
        assigned_jobs.push({ "work_id": split[1], "person_id": split[2], "location_id": split[3] })
    })
    $("#saveAllInformation").removeClass("btn-success")
    $("#saveAllInformation").removeClass("btn-danger")

    $.ajax({
        type: "POST",
        url: $("#link_to_save_data").attr("href"),// this is so cursed
        data: {
            assigned_jobs: assigned_jobs
        },
        success: function () {
            $("#saveAllInformation").addClass("btn-success")
        },
        error: function () {
            $("#saveAllInformation").addClass("btn-danger")
        }
    });
    console.log(assigned_jobs);
})

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev, id) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    element = document.getElementById(data)
    console.log(element.getAttribute("from"))
    console.log(id)
    if (element.getAttribute("from") == id) {
        ev.target.appendChild(document.getElementById(data));
    }
}

$('#employee-birthday').on('keydown keyup keypress', function(e) {
    e.preventDefault();
    return false;
});