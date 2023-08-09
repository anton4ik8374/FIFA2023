import * as React from 'react';
import moment from 'moment';
import {Card} from '@mui/material';
import CardContent from '@mui/material/CardContent';
import Avatar from '@mui/material/Avatar';
import Typography from '@mui/material/Typography';
import {Box} from "@mui/material";
import MatchesStore from "@/Stores/MatchesStore";
import {observer} from "mobx-react";
import {Divider} from "@mui/material";
import CardStyle from "@/Styles/CardStyle";
import {styled} from '@mui/material/styles';
import Button from '@mui/material/Button';
import {deepPurple} from '@mui/material/colors';
import CircularWithValueLabel from "@/Components/CircularProgressWithLabel";
import MacheSkeleton from "@/Skeletons/MacheSkeleton";
import CharDoughnut from "@/Components/Charts";


const MatcheDetails = observer(() => {

    let {match} = MatchesStore;

    const ColorButton = styled(Button)(({theme}) => ({
        color: theme.palette.getContrastText(deepPurple[400]),
        margin: 8,
        backgroundColor: deepPurple[400],
        '&:hover': {
            backgroundColor: deepPurple[600],
        },
    }));
    const moreForecasts = () => {
        console.log(2);
    }
    const getText = (text) => {
        return text.replaceAll('_', ' ');
    }
    const getWin = () => {
        let win = 'Undefined';
        if (match?.result?.win_team_id) {
            switch (match.result?.win_team_id) {
                case match?.team_home?.id:
                    win = 'Team 1';
                    break;
                case match?.teams_away?.id:
                    win = 'Team 2';
                    break;
                default:
                    win = 'Drawn';
            }
        }
        return win;
    }
    const getBet = () => {
        let result = '';
        if (match?.result?.chat_gpt_result) {
            let stringArr = match?.result?.chat_gpt_result.split(':');
            if (stringArr[2] !== undefined) {
                result = stringArr[2];
            }
        }
        return result;
    }
    let statistics = match?.statistics?.map(ellement => {
        return (<Box key={ellement.id}>
            <Box sx={{...CardStyle.containerMatch, ...CardStyle.footerBlock}}>
                <Typography
                    sx={{...CardStyle.league, ...CardStyle.footerText, ...CardStyle.footerBorder}}>{`${ellement?.total} of users bets on ${getText(ellement?.bet)}`}</Typography>
            </Box>
            <Box>
                <Box sx={CardStyle.containerFooter}>
                    <Box sx={CardStyle.containerResult}>
                        <CircularWithValueLabel all={match?.result?.count_forecasts}
                                                win={ellement?.total}/>
                        <Typography sx={CardStyle.team}>{getText(ellement?.bet)}</Typography>
                    </Box>
                    <ColorButton style={{textTransform: 'none'}} variant="contained"
                                 onClick={() => console.log('1')}>
                        {`${ellement?.odds.toFixed(2)} | Bet`}
                    </ColorButton>
                </Box>
            </Box>
        </Box>)
    });

    return (
        <>
            {match.id &&
                (<>
                    <Card maxWidth="xs" sx={CardStyle.card}>
                        <CardContent>
                            <Typography sx={CardStyle.league} variant="p">{`#id: ${match?.id} `}</Typography>
                            <Typography sx={CardStyle.league} variant="p">{match?.league?.name}</Typography>
                            <Box sx={CardStyle.containerMatch}>
                                <Box>
                                    <Box sx={CardStyle.blockTeam}>
                                        <Avatar sx={CardStyle.imagesTeam} alt={match?.team_home?.name}
                                                src={match?.team_home?.logo ? `/storage${match?.team_home?.logo}` : `/storage/logos/soccer_ball.png`}/>
                                        <Typography sx={CardStyle.team}>{match?.team_home?.name}</Typography>
                                    </Box>
                                    <Box sx={CardStyle.blockTeam}>
                                        <Avatar sx={CardStyle.imagesTeam} alt={match?.teams_away?.name}
                                                src={match?.teams_away?.logo ? `/storage${match?.teams_away?.logo}` : `/storage/logos/soccer_ball.png`}/>
                                        <Typography sx={CardStyle.team}>{match?.teams_away?.name}</Typography>
                                    </Box>
                                </Box>
                                <Box>
                                    <Typography sx={CardStyle.dateTime}>
                                        {moment(match?.date_event).calendar()}
                                    </Typography>
                                </Box>
                            </Box>
                            <Typography variant="p" sx={CardStyle.win} >{`Most popular bet ${getWin()}`}</Typography>
                            <Box sx={CardStyle.footballField}>
                                <Box sx={{...CardStyle.circle, ...CardStyle.circleLeft}}></Box>
                                <Box sx={{...CardStyle.circleCenter}}>
                                    <CharDoughnut/>
                                    <Typography variant="p" sx={CardStyle.winPole} >{getWin()}</Typography>
                                </Box>
                                <Box sx={{...CardStyle.lineWertycal}}>
                                </Box>
                                <Box sx={{...CardStyle.circle, ...CardStyle.circleRight}}></Box>
                            </Box>
                            <Box >
                                <Box>
                                    <Typography variant="h5" sx={CardStyle.based} >{`Based on ${match.forecasts_count} tips`}</Typography>
                                    <Typography sx={CardStyle.league} color="text.secondary">{`ChatGPR result: ${getBet()}`}</Typography>
                                </Box>
                            </Box>
                            {statistics}
                        </CardContent>
                        <Divider/>
                    </Card>
                    <Box maxWidth="xs" sx={CardStyle.blockTeam}>
                        <ColorButton fullWidth={true} variant="contained" onClick={() => moreForecasts()}>
                            More forecasts
                        </ColorButton>
                    </Box>
                </>)}
            {!match.id &&
                (<MacheSkeleton/>)}
        </>
    );
});

export default MatcheDetails;
