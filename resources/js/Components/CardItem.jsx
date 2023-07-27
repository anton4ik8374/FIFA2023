import * as React from 'react';
import moment from 'moment';
import {Card} from '@mui/material';
import CardContent from '@mui/material/CardContent';
import Avatar from '@mui/material/Avatar';
import Typography from '@mui/material/Typography';
import {Box} from "@mui/material";
import {useEffect} from "react";
import MatchesStore from "@/Stores/MatchesStore";
import {observer} from "mobx-react";
import {Divider} from "@mui/material";
import CardStyle from "@/Styles/CardStyle";
import {styled} from '@mui/material/styles';
import Button from '@mui/material/Button';
import {deepPurple} from '@mui/material/colors';
import CircularWithValueLabel from "@/Components/CircularProgressWithLabel";
import {Link} from "react-router-dom";
import {generatePath} from "react-router";
import {routesMap} from "@/Common/Routers/MapRouter"


const CardItem = observer(() => {

    let {matches} = MatchesStore;

    useEffect(() => {
        MatchesStore.getActualMatches();
    }, []);

    const ColorButton = styled(Button)(({theme}) => ({
        color: theme.palette.getContrastText(deepPurple[400]),
        margin: 8,
        backgroundColor: deepPurple[400],
        '&:hover': {
            backgroundColor: deepPurple[600],
        },
    }));
    const reload = () => {
        MatchesStore.getActualMatches();
    }
    const getWin = (item) => {
        let win = 'Undefined';
        if (item?.result?.win_team_id) {
            switch (item.result?.win_team_id) {
                case item?.team_home?.id:
                    win = 'Team 1';
                    break;
                case item?.teams_away?.id:
                    win = 'Team 2';
                    break;
                default:
                    win = item?.teams_away?.id;
            }
        }
        return win;
    }
    const getBet = (item) => {
        let result = '';
        if(item?.result?.chat_gpt_result){
            let stringArr = item?.result?.chat_gpt_result.split(':');
            if(stringArr[2] !== undefined){
                result = stringArr[2];
            }
        }
        return result;
    }

    let matchesRender = matches.map(item => {
        return (
            <Card maxWidth="xs" sx={CardStyle.card}>
                <CardContent>
                    <Typography sx={CardStyle.league} variant="p"
                                color="text.secondary">{item?.league?.name}</Typography>
                    <Box sx={CardStyle.containerMatch}>
                        <Box>
                            <Box sx={CardStyle.blockTeam}>
                                <Avatar alt={item?.team_home?.name} src={`/storage${item?.team_home?.logo}`}/>
                                <Typography sx={CardStyle.team}>{item?.team_home?.name}</Typography>
                            </Box>
                            <Box sx={CardStyle.blockTeam}>
                                <Avatar alt={item?.teams_away?.name} src={`/storage${item?.teams_away?.logo}`}/>
                                <Typography sx={CardStyle.team}>{item?.teams_away?.name}</Typography>
                            </Box>
                        </Box>
                        <Box>
                            <Typography sx={CardStyle.dateTime}>
                                {moment(item?.date_event).calendar()}
                            </Typography>
                        </Box>
                    </Box>
                    <Box sx={CardStyle.footer}>
                        <Box>
                            <Typography sx={CardStyle.league} color="text.secondary">{getBet(item)}</Typography>
                            <Box sx={CardStyle.containerFooter}>
                                <Box sx={CardStyle.containerResult}>
                                    <CircularWithValueLabel all={item?.result?.count_forecasts}
                                                            win={item?.result?.count_forecasts_win}/>
                                    <Typography sx={CardStyle.team}>{getWin(item)}</Typography>
                                </Box>
                                <ColorButton style={{textTransform: 'none'}} variant="contained" onClick={() => reload()}>
                                    ?.? | Bet
                                </ColorButton>
                            </Box>
                        </Box>
                        <Box sx={{...CardStyle.containerMatch, ...CardStyle.footerBlock}}>
                            <Typography sx={{...CardStyle.league, ...CardStyle.footerText}}>{`Based on ${item?.forecasts_count} tips`}</Typography>
                            <Link to={generatePath(routesMap.matches, {matches: 'zz-ss'})} style={{...CardStyle.league, ...CardStyle.footerLink}}>{'Read more >'}</Link>
                        </Box>
                    </Box>

                </CardContent>
                <Divider/>
            </Card>
        );
    });

    return (
        <>
            {matchesRender}
            <Box maxWidth="xs" sx={CardStyle.blockTeam}>
                <ColorButton fullWidth={true} variant="contained">
                    Show more
                </ColorButton>
            </Box>
            <Box maxWidth="xs" sx={CardStyle.blockTeam}>
                <ColorButton fullWidth={true} variant="contained" onClick={() => reload()}>
                    Reload
                </ColorButton>
            </Box>
        </>
    );
});

export default CardItem;
