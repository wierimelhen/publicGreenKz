// api.greenkz.bikli.kz
// 192.168.1.168:8084
const REACT_APP_HOST = "api.greenkz.bikli.kz";
const PROTOCOL = "https";

const api = {
    // async login(data: FormData) {
    //     const response = await fetch(
    //         `${PROTOCOL}://${REACT_APP_HOST}/api/login_auth`,

    //         {
    //             method: "POST",
    //             body: data,
    //         },
    //     );

    //     const jsonData = await response.json();

    //     const token = response.headers.get("authorization")
    //         ? response.headers.get("authorization")?.toString()
    //         : "";

    //     sessionStorage.setItem("jwt", token ? token : "");

    //     return jsonData;
    // },

    async getDataPark(data: FormData) {
        const response = await fetch(
            `${PROTOCOL}://${REACT_APP_HOST}/api/getDataPark`,
            {
                method: "POST",
                body: data,
                headers: {
                    Accept: "application/json",
                    // "Content-Type": "application/json",
                    // Authorization: "Bearer " + sessionStorage.getItem("jwt"),
                },
            },
        );

        const jsonData = await response.json();

        return jsonData;
    },


};

export default api;
