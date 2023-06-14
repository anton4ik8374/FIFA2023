import React from 'react';
import Skeleton from '@mui/material/Skeleton';
import Card from '@mui/material/Card';
import CardHeader from '@mui/material/CardHeader';

const MenuSkeleton = () => {

    return (
        <Card >
            <CardHeader>
                <Skeleton animation="wave" variant="circle" width={40} height={40} />
            </CardHeader>
        </Card>
    );
}

export default MenuSkeleton();
