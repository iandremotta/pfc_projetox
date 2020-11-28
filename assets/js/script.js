function addGroupModal() {
  var html = "<h1>Criar nova sala</h1>";
  html +=
    '<input type="text" id="newGroupName" placeholder="Digite o nome da sala."/>';
  html +=
    '<br><input type="button" id="newGroupButton" value="Cadastrar" class="btnModal"/>';
  html += "<hr><br/>";
  html +=
    '<button onclick="fecharModal()" class="btnModal">Fechar janela</button>';

  $(".modal_area").html(html);
  $(".modal_bg").show();
  $("#newGroupButton").on("click", function () {
    var newGroupName = $("#newGroupName").val();
    if (newGroupName != "") {
      //envia via ajax
      chat.addNewGroup(newGroupName, function (json) {
        if (json.error == "0") {
          $(".add_tab").click();
        } else {
          alert(json.errorMsg);
        }
      });
    }
  });
}

function fecharModal() {
  $(".modal_bg").hide();
}
// funções do chat
$(function () {
  if(group_list.length>0)
  {
    for(var i in group_list){
      chat.setGroup(group_list[i].id, group_list[i].name);
    }
  }
  chat.chatActivity();
  chat.userListActivity();

  $(".add_tab").on("click", function () {
    html = "<h1>Escolha uma sala de bate papo</h1>";
    html += '<div id="groupList">Carregando...</div>';
    html += "<hr><br/>";
    html +=
      '<button onclick="addGroupModal()" class="btnModal">Criar nova sala</button>';
    html +=
      '<button onclick="fecharModal()" class="btnModal">Fechar janela</button>';
    $(".modal_area").html(html);
    $(".modal_bg").show();

    // Requisição das salas, recebe um json e passa em html...
    chat.loadGroupList(function (json) {
      var html = "";
      for (var i in json.list) {
        html +=
          // passa os dados do json...
          '<button data-id="' + //p
          json.list[i].id +
          '">' +
          json.list[i].name +
          "</button>";
      }
      $("#groupList").html(html);

      // eventos de click
      $("#groupList")
        .find("button")
        .on("click", function () {
          var cid = $(this).attr("data-id"); //chat id
          var cnm = $(this).text(); //chat nome
          chat.setGroup(cid, cnm); //seta chatid e chat nome...
          $(".modal_bg").hide();
        });
    });
  });

  $("nav ul").on("click", "li .group_name", function () {
    // pega o id
    var id = $(this).parent().attr("data-id");
    chat.setActiveGroup(id);
  });

  $("nav ul").on("click", "li .group_close", function () {
    // pega o id
    var id = $(this).parent().attr("data-id");
    chat.removeGroup(id);
  });
  // recebe as mensagens após apertar ENTER
  $("#sender_input").on("keyup", function (e) {
    if (e.keyCode == 13) {
      var msg = $(this).val();
      $(this).val("");
      chat.sendMessage(msg); //passa mensagem como parametro
    }
  });
  //recebe as mensagens após clickar...
  $(".sender_tool").on("click", function () {
    var msg = $("#sender_input").val();
    $("#sender_input").val("");
    chat.sendMessage(msg);
    console.log(msg);
  });
  //envio de foto
  $(".imgUploadBtn").on("click", function () {
    $("#sender_input_img").trigger("click");
  });
  $("#sender_input_img").on("change", function (e) {
    chat.sendPhoto(e.target.files[0]);
  });
  $(".messages").on("click", function () {
    $(".messages").scrollBy(0, 500);
  });
});

//testes de scroll
