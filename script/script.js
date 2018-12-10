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
                let words = JSON.parse(response);
                let link, th, td, tr, element;
                let count = 1;
                words.forEach(function (url) {
                    element = document.getElementById("result");
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
}

function urlIndexed() {
    let url = document.getElementById("url").value;
    url = url.trim();
    let valid = /^(ftp|http|https):\/\/[^ "]+$/.test(url);


    if (valid) {
        document.getElementById("img").style.display = 'inline-block';
        document.getElementById("index").Disabled = true;

        $.ajax({
            type: "POST",
            data: {name: url},
            dataType: "html",
            url: "ajax.php",
            cache: false,
            success: function (response) {
                document.getElementById("img").style.display = 'none';
                document.getElementById("index").Disabled = false;
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