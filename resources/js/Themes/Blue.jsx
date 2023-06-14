import { createTheme } from '@mui/material/styles';
import {blue} from "@mui/material/colors";


const theme = createTheme({
    palette: {
        //mode: 'dark',
        primary: {
            main: blue[500],

        },
        secondary: {
            main: blue[300]
        }
    },
    components: {

    },
});
export default theme;
