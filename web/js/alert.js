class Alerts {
    static prompt = (message, defaultText = "") => prompt(message, defaultText);
    static comfirm = (message) => confirm(message);
}