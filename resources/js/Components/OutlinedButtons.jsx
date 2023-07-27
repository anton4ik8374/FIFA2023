import * as React from 'react';
import Button from '@mui/material/Button';
import Stack from '@mui/material/Stack';
import UserStore from "@/Stores/UserStore";


export default function OutlinedButtons() {

    let {user, errors} = UserStore;

    const Stavka = () => {
        UserStore.Stavka();
    };
    const OlbgLoad = () => {
        UserStore.OlbgLoad();
    };
    const OlbgGet = () => {
        UserStore.OlbgGet();
    };
    const ChatGPT = () => {
        UserStore.ChatGPT();
    };

    return (
        <>
            <Stack direction="row" spacing={0}>
                <Button variant="outlined" onClick={ChatGPT}>ChatGPT</Button>
                <Button variant="outlined" onClick={Stavka}>Stavka</Button>
                <Button variant="outlined" onClick={OlbgLoad}>OlbgL</Button>
                <Button variant="outlined" onClick={OlbgGet}>OlbgG</Button>
            </Stack>

        </>
    );
}
