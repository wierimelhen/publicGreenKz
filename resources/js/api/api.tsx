// api.greenkz.bikli.kz
// 192.168.1.168:8084
const REACT_APP_HOST = "api.greenkz.bikli.kz";
const PROTOCOL = "https";

const api = {
    async login(data: FormData) {
        const response = await fetch(
            `${PROTOCOL}://${REACT_APP_HOST}/api/login_auth`,

            {
                method: "POST",
                body: data,
            },
        );

        const jsonData = await response.json();

        const token = response.headers.get("authorization")
            ? response.headers.get("authorization")?.toString()
            : "";

        sessionStorage.setItem("jwt", token ? token : "");

        return jsonData;
    },

    async addTree(data: FormData) {
        const response = await fetch(
            `${PROTOCOL}://${REACT_APP_HOST}/api/addTree`,
            {
                method: "POST",
                body: data,
                headers: {
                    Accept: "application/json",
                    // "Content-Type": "application/json",
                    Authorization: "Bearer " + sessionStorage.getItem("jwt"),
                },
            },
        );

        const jsonData = await response.json();

        return jsonData;
    },

    async getTreeSpecies() {
        const data = await fetch(
            `${PROTOCOL}://${REACT_APP_HOST}/api/getTreeSpecies`,
            {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    // "Content-Type": "application/json",
                    Authorization: "Bearer " + sessionStorage.getItem("jwt"),
                },
            },
        )
            .then(function (response) {
                const jsonData = response.json();
                return jsonData;
            })
            .then(function (result) {
                return result;
            });

        return data;
    },

    async getTreeOwners() {
        const data = await fetch(
            `${PROTOCOL}://${REACT_APP_HOST}/api/getTreeOwners`,
            {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    // "Content-Type": "application/json",
                    Authorization: "Bearer " + sessionStorage.getItem("jwt"),
                },
            },
        )
            .then(function (response) {
                const jsonData = response.json();
                return jsonData;
            })
            .then(function (result) {
                console.log(result);
                return result;
            });

        return data;
    },

    async getTreeVitalities() {
        const data = await fetch(
            `${PROTOCOL}://${REACT_APP_HOST}/api/getTreeVitalities`,
            {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    // "Content-Type": "application/json",
                    Authorization: "Bearer " + sessionStorage.getItem("jwt"),
                },
            },
        )
            .then(function (response) {
                const jsonData = response.json();
                return jsonData;
            })
            .then(function (result) {
                return result;
            });

        return data;
    },
};

export default api;
