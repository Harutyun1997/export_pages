document.getElementById("word").addEventListener('keyup', periodChange);
document.getElementById("index").addEventListener('click', urlIndexed);

function searchUrl() {

    let str = document.getElementById("word").value;
    str = str.trim();

    if (str !== "") {

        $.ajax({
            type: "GET",
            data: {name: str},
            dataType: "html",
            url: "ajax.php",
            cache: false,
            success: function (response) {
                let urls = JSON.parse(response);
                let link, th, td, tr;
                let element = document.getElementById("result");
                let count = 1;
                element.innerHTML = '';
                urls.forEach(function (url) {

                    tr = document.createElement("tr");
                    th = document.createElement("th");
                    th.setAttribute('scope', 'col');
                    th.innerText = count;
                    tr.appendChild(th);
                    td = document.createElement("td");
                    td.innerText = url[0];
                    tr.appendChild(td);

                    td = document.createElement("td");
                    link = document.createElement("a");
                    link.setAttribute('href', url[1]);
                    link.innerText = url[1];
                    td.appendChild(link);
                    tr.appendChild(td);
                    element.appendChild(tr);
                    count += 1
                })
            }
        });
    }
    else {
        document.getElementById("result").innerText ='';
    }
}

function urlIndexed() {
    let url = document.getElementById("url").value;
    url = url.trim();
    let valid = /^(ftp|http|https):\/\/[^ "]+$/.test(url);

    if (valid) {
        document.getElementById('index').setAttribute("disabled", "disabled");
        document.getElementById("img").style.display = 'inline-block';

        $.ajax({
            type: "POST",
            data: {name: url},
            dataType: "html",
            url: "ajax.php",
            cache: false,
            success: function (response) {
                document.getElementById("img").style.display = 'none';
                document.getElementById('index').removeAttribute("disabled");
                let par = document.getElementById("response");
                par.innerText = response;
            }
        });
    }
}

let periodicChangeTimer;

function periodChange() {
    clearTimeout(periodicChangeTimer);
    periodicChangeTimer = setTimeout(searchUrl, 1000);

}