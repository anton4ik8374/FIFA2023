import {observer} from "mobx-react";
import {NavLink} from 'react-router-dom';
import {styled} from '@mui/material/styles';
import {blue} from "@mui/material/colors";

const UseLink = observer(({to, name, color = blue}) => {

    const StyledLink = styled(NavLink)`
      color: ${color[900]};
      text-decoration: none;
      font-size: 1.10rem;
      padding: 16px;

      &.active {
        color: ${color[300]};
      }

      &:hover {
        color: ${color[600]};
      }
    `;

    return (<StyledLink to={to}>{name}</StyledLink>);
});

export default UseLink;
