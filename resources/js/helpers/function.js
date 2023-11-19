export function formatRupiah(number) {
    if (typeof number !== "number") {
        return "Invalid input";
    }

    const formattedNumber = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(number);

    return formattedNumber;
}

export function formatDateYMD(date) {
    if (!(date instanceof Date)) {
      return "Invalid Date";
    }

    const options = {
        day: "numeric",
        month: "long",
        year: "numeric",
        hour: "numeric",
        minute: "numeric",
        second: "numeric"
    };
    return new Intl.DateTimeFormat("id-ID", options).format(date);
}
