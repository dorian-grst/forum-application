const between8And16Chars = (pwd) => pwd.length >= 8 && pwd.length <= 16;
const oneUpperCaseAndOneSpecialChar = (pwd) => pwd.match(/[^A-Za-z0-9]/) && pwd.match(/[A-Z]/);

const onPwdChange = (pwd) => {
    const nbIndicator = document.getElementById("len-indicator");
    const upperSpecial = document.getElementById("upper-indicator");
    const button = document.getElementById("create");
    const same = document.getElementById("same-indicator");
    const pwd1 = document.getElementById("pwdId").value;
    const pwd2 = document.getElementById("pwdComfirm").value;

    nbIndicator.style.backgroundColor = between8And16Chars(pwd) ? "#51ECC7" : "#F53563";
    upperSpecial.style.backgroundColor = oneUpperCaseAndOneSpecialChar(pwd) ? "#51ECC7" : "#F53563";
    same.style.backgroundColor = pwd1 == pwd2 ? "#51ECC7" : "#F53563";

    button.disabled = !(between8And16Chars(pwd) && oneUpperCaseAndOneSpecialChar(pwd) && pwd1 == pwd2);
}
